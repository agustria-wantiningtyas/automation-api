<?php

namespace App\Http\Controllers;

use App\Helpers\Helper as Helper;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use App\Models\TestCase;
use Illuminate\Http\Request;

class TestCaseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('token')) {
            $userActive = User::userActive($request->token);
            if ($userActive) {
                $user = User::userByToken($request->token);
                if (!empty($user)) {
                    $active = 'Y';
                    $content = $this->_tableAttribute($request, $active, $user->id);
                    $dataValue = array();
                    $dataCount = 0;
                    $testcase = new TestCase();
                    $getData = $testcase->getAllData($content);
                    

                    if (!$getData['data']->isEmpty()) {
                        $dataCount = $getData['count'];
                        $dataValue = $this->_setTestCaseData($getData['data']);
                    }
                    $data = Helper::_success();
                    $data['data'] = $dataValue;
                    $data['totalRecords'] = $dataCount;
                } else {
                    $data = Helper::_getDataIfSessionExpired();
                    $data['data'] = array();
                }
            } else {
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_methodNotAllowed();
            $data['error'] = 1;
        }
        return response()->json($data, 200);
    }

    public function indexExport(Request $request)
    {
        if ($request->has('token')) {
            $userActive = User::userActive($request->token);
            if ($userActive) {
                $user = User::userByToken($request->token);
                if (!empty($user)) {
                    $active = 1;
                    $content = $this->_tableAttribute($request, $active);
                    $dataValue = array();
                    $dataCount = 0;
                    $employee = new Employee();
                    $getData = $employee->getAllDataExport($content);
                    if (!$getData['data']->isEmpty()) {
                        $dataCount = $getData['count'];
                        $dataValue = $this->_setEmployeeData($getData['data']);
                    }
                    $data = Helper::_success();
                    $data['data'] = $dataValue;
                    $data['totalRecords'] = $dataCount;
                } else {
                    $data = Helper::_getDataIfSessionExpired();
                    $data['data'] = array();
                    $data['error'] = 1;
                }
            } else {
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_methodNotAllowed();
            $data['error'] = 1;
        }
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($request->has('token')) {
            $userActive = User::userActive($request->token);
            if ($userActive) {
                $user = User::userByToken($request->token);
                if (!empty($user)) {
                    $content = array(
                        'name' => $request->test_case,
                        'user_id' => $user->id
                    );
                    $result = TestCase::store($content);
                    if ($result) {
                        $data = Helper::_success();
                    } else {
                        $data = Helper::_noContent();
                    }
                    
                } else {
                    $data = Helper::_getDataIfSessionExpired();
                    $data['data'] = array();
                    $data['error'] = 1;
                }
            } else {
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_methodNotAllowed();
            $data['error'] = 1;
        }
        return response()->json($data, 200);
    }

    public function show(Request $request)
    {
        if ($request->has('token')) {
            $userActive = User::userActive($request->token);
            if ($userActive) {
                $user = User::userByToken($request->token);
                if (!empty($user)) {
                    $id = $request->has('id') ? $request->id : '';
                    $result = TestCase::show($id);
                    if ($result) {
                        $data = Helper::_success();
                        $data['data'] = $result;
                    } else {
                        $data = Helper::_noContent();
                    }

                } else {
                    $data = Helper::_getDataIfSessionExpired();
                    $data['data'] = array();
                    $data['error'] = 1;
                }
            } else {
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_methodNotAllowed();
            $data['error'] = 1;
        }
        return response()->json($data, 200);
    }

    public function showByStatus(Request $request)
    {
        if ($request->has('token')) {
            $userActive = User::userActive($request->token);
            if ($userActive) {
                $user = User::userByToken($request->token);
                if (!empty($user)) {
                    $result = TestCase::showByStatus($user->id);
                    if ($result) {
                        $data = Helper::_success();
                        $data['data'] = $result;
                    } else {
                        $data = Helper::_noContent();
                    }

                } else {
                    $data = Helper::_getDataIfSessionExpired();
                    $data['data'] = array();
                    $data['error'] = 1;
                }
            } else {
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_methodNotAllowed();
            $data['error'] = 1;
        }
        return response()->json($data, 200);
    }
    public function update(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($request->has('token')) {
            $userActive = User::userActive($request->token);
            if ($userActive) {
                $user = User::userByToken($request->token);
                if (!empty($user)) {
                    $content = array(
                        'id' => $request->has('id') ? $request->id : '',
                        'name' => $request->name,
                        'status' => $request->status
                    );
                    $result = TestCase::edit($content);
                    if ($result) {
                        $data = Helper::_success();
                    } else {
                        $data = Helper::_badRequest();
                    }
                } else {
                    $data = Helper::_getDataIfSessionExpired();
                    $data['data'] = array();
                    $data['error'] = 1;
                }

            } else {
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_methodNotAllowed();
            $data['error'] = 1;
        }
        return response()->json($data, 200);
    }

    public function delete(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        if ($request->has('token')) {
            $userActive = User::userActive($request->token);
            if ($userActive) {
                $user = User::userByToken($request->token);
                if (!empty($user)) {
                    $id = $request->has('id') ? $request->id : '';
                    $content = array(
                        'id' => $request->has('id') ? $request->id : '',
                        'status' => 'N',
                        'deleted_by' => $user->id,
                    );
                    $result = Employee::actionDelete($content);
                    if ($result) {
                        $data = Helper::_success();
                    } else {
                        $data = Helper::_badRequest();
                    }
                } else {
                    $data = Helper::_getDataIfSessionExpired();
                    $data['data'] = array();
                    $data['error'] = 1;
                }

            } else {
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_methodNotAllowed();
            $data['error'] = 1;
        }
        return response()->json($data, 200);
    }

    public static function _setTestCaseData($data)
    {
        foreach ($data as $value) {
            $returnData[] = array(
                'id' => $value->id,
                'name' => $value->name,
                'status' => $value->status,
                'created_at' => $value->created_at
            );
        }
        return $returnData;
    }

    public static function _tableAttribute($request, $status, $user_id)
    {
        $content = array(
            'limit' => $request->has('limit') ? $request->limit : 10,
            'skip' => $request->has('skip') ? $request->skip : 0,
            'filters' => $request->has('filters') ? $request->filters : null,
            'sortOrder' => $request->has('sortOrder') ? $request->sortOrder : 'DESC',
            'order' => $request->has('order') ? $request->order : 'name',
            'status' => $status,
            'user_id'   => $user_id
        );

        return $content;
    }
}
