<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper as Helper;
use App\Models\WmsApproval;
use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\WmsLeaveSetting;
use function GuzzleHttp\json_encode;
use App\Models\WmsRequestApprover;
use App\Models\WmsUserApprover;
use App\Models\WmsRequestAppHistory;
use function GuzzleHttp\json_decode;
class Controller extends BaseController
{
    public function checkImagePath(Request $request)
    {
        $photo = $request->has('photo') ? $request->photo: null;
        if($photo != null){
            $check_file = base_path('public/images/180/attendance/' . $request->photo);
            if (file_exists($check_file)) {
                $new_photo = env('IMG_PUBLIC_PATH') . '180/attendance/' . $request->photo;
                $exist = true;
            } else {
                $new_photo = "https://xremo.com/wms-api-ktm/public/images/180/attendance/" . $request->photo;
                $exist = false;
            }
            $data = Helper::_success();
            $data['data'] = array(
                'photo' => $new_photo,
                'exist' => $exist
            );
        }else{
            $data = Helper::_badRequest();
            $data['message_detail'] = "You need to send photo attribute";
        }
        return response()->json($data, 200);
    }

    public function autoApprove()
    {
        $autoData = WmsApproval::getAllActiveSetting();
        if($autoData != false){
            foreach($autoData as $value){
                if($value->menu_id == 7){
                    $getLeaveData = Leave::getLeaveForAuto($value->day_limit, [1,2]);
                    if($getLeaveData!= false){
                        // var_dump(json_encode($getLeaveData, JSON_PRETTY_PRINT));exit;
                        foreach($getLeaveData as $leave){
                            $setLeaveData = array(
                                'id' => $leave->id,
                                'leave_token' => $leave->leave_token,
                                'leave_type' => $leave->leave_type,
                                'type' => $leave->type,
                                'leave_day_type' => $leave->leave_day_type,
                                'leave_by' => $leave->leave_by,
                                'leave_date' => $leave->leave_date,
                                'leave_start_time' => $leave->leave_start_time,
                                'leave_end_time' => $leave->leave_end_time,
                                'leave_description' => $leave->leave_description,
                                'leave_doc_file' => $leave->leave_doc_file,
                                'leave_status' => $leave->leave_status,
                            );
                            if($value->type == 1){
                                // Auto Approve
                                $setLeaveData['status'] = 3;
                                $setLeaveData['note'] = 'This request approved automatically by system';
                            }else{
                                // Auto Reject
                                $setLeaveData['status'] = 0;
                                $setLeaveData['note'] = 'This request rejected automatically by system';
                            }
                            app('App\Http\Controllers\Standart\LeaveController')->autoChangeStatus($setLeaveData);
                        }
                        $data = Helper::_success();
                    }else{
                        $data = Helper::_noContent();
                    }
                }else{
                    $data = Helper::_noContent();
                }
            }
        }else{
            $data = Helper::_noContent();
        }
        return response()->json($data, 200);
    }

    public function autoLeaveAdditionalPeriod(){
        $getPeriodLeaveType = LeaveType::getLeaveTypePeriod();
        if($getPeriodLeaveType != false){
            foreach($getPeriodLeaveType as $value){
                $leaveTypeId[] = array($value->id);
            }
            $getLeaveSettingData = WmsLeaveSetting::getDataByLeaveTypeId($leaveTypeId);
            if($getLeaveSettingData != false){
                foreach($getLeaveSettingData as $value){
                    if(date('d') == $value->leave_additional_period){
                        WmsLeaveSetting::addBalance($value->id, 1);
                    }
                }
                $data = Helper::_success();
            }else{
                $data = Helper::_noContent();
            }
        }else{
            $data = Helper::_noContent();
        }
        return response()->json($data, 200);
    }

    public function autoUpdateApprover()
    {
        $leaveApprover = WmsRequestApprover::getPendingLeave();
        $exceptionalApprover = WmsRequestApprover::getPendingExceptional();
        $getUserApprover = WmsUserApprover::getAllUserApprover();
        $approverData = $this->_getApproverLists($leaveApprover, $exceptionalApprover);
        if($getUserApprover != false){
            if(!empty($approverData)){
                $updateData = $this->_validateApproverData($getUserApprover, $approverData);
                if(!empty($updateData)){
                    $id = $this->_getApproverId($updateData);
                    $approvedBy = $this->_getApproverUpdateApprovedBy($updateData);
                    // $test = str_replace(array('{', '}, {', '}'), array('', ',', '', '}'), json_encode($approvedBy));
                    // $test = str_replace(array('[',']'),array('[{','}]'),$test);
                    // print_r(json_decode($test, true));exit;

                    // $isUpdated = WmsRequestApprover::updateApprover($id, $approvedBy);
                    $isUpdated = true;
                    foreach($updateData as $item){
                        if(!WmsRequestApprover::updateApprover([$item['id']], array('approved_by' => $item['approved_by']))){
                            $isUpdated = false;
                        }
                    }
                    if($isUpdated){
                        $data = Helper::_success();
                    }else{
                        $data = Helper::_badRequest();
                        $data['message_detail'] = 'Fail to update Approver!';
                    }
                }else{
                    $data = Helper::_noContent();
                    $data['message_detail'] = 'No Approver Data Need to Changes!';
                }
            }else{
                $data = Helper::_noContent();
                $data['message_detail'] = 'No Approver List!';
            }
        }else{
            $data = Helper::_noContent();
            $data['message_detail'] = 'No User Approver List!';
        }
        return response()->json($data, 200);
    }

    public function _getApproverId($fixData){
        foreach($fixData as $item){
            $data[] = $item['id'];
        }
        return $data;
    }

    public function _getApproverUpdateApprovedBy($fixData){
        foreach($fixData as $item){
            $data[] = array('approved_by' => $item['approved_by']);
        }
        return $data;
    }

    public function _validateApproverData($userApprover, $dataApprover){
        $data = array();
        foreach($userApprover as $value){
            foreach($dataApprover as $item){
                if($value->account_id == $item['account_id']){
                    if($item['approved_level'] == 1){
                        if($item['approved_by'] != $value->approver_1){
                            if($value->approver_1 != null || $value->approver_1 != ''){
                                $data[] = array(
                                    'id' => $item['id'],
                                    'approved_by' => $value->approver_1,
                                );
                            }
                        }
                    }else if($item['approved_level'] == 2){
                        if($item['approved_by'] != $value->approver_2){
                            if($value->approver_2 != null || $value->approver_2 != ''){
                                $data[] = array(
                                    'id' => $item['id'],
                                    'approved_by' => $value->approver_2,
                                );
                            }
                        }
                    }else if($item['approved_level'] == 3){
                        if($item['approved_by'] != $value->approver_3){
                            if($value->approver_2 != null || $value->approver_2 != ''){
                                $data[] = array(
                                    'id' => $item['id'],
                                    'approved_by' => $value->approver_3,
                                );
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function _getApproverLists($leaveData, $exceptionalData)
    {
        $data = array();
        if($leaveData != false){
            foreach($leaveData as $value){
                $data[] = array(
                    'id' => $value->id,
                    'account_id' => $value->account_id,
                    'approved_by' => $value->approved_by,
                    'approved_level' => $value->approved_level,
                );
            }
        }
        if($exceptionalData != false){
            foreach($exceptionalData as $value){
                $data[] = array(
                    'id' => $value->id,
                    'account_id' => $value->account_id,
                    'approved_by' => $value->approved_by,
                    'approved_level' => $value->approved_level,
                );
            }
        }
        return $data;
    }
}
