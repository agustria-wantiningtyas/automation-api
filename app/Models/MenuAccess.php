<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuAccess extends Model
{
 protected $table = 'wms_menu_access';
 protected $primaryKey = 'id';
 public $timestamps = false;

    public static function checkUserMenu($id, $data){
        return Self::where('account_id', $id)->where('menu_id', $data['menu_id'])->first();
    }

    public static function updateUserMenu($user, $data, $by){
        date_default_timezone_set('Asia/Jakarta');

        $user->access_add = $data['access']['access_add'];
        $user->access_edit = $data['access']['access_edit'];
        $user->access_view = $data['access']['access_view'];
        $user->access_delete = $data['access']['access_delete'];
        $user->access_approve = $data['access']['access_approve'];
        $user->active = $data['access']['active'];
        $user->updated_by = $by;
        $user->updated_at = date('Y-m-d H:i:s');

        if($user->update()){
            return true;
        }else{
            return false;
        }
    }

    public static function addUserMenu($account_id, $cus_id, $data, $by){
        date_default_timezone_set('Asia/Jakarta');
        $add = array(
            'account_id' => $account_id,
            'cus_id' => $cus_id,
            'menu_id' => $data['menu_id'],
            'active' => $data['access']['active'],
            'access_add' => $data['access']['access_add'],
            'access_edit' => $data['access']['access_edit'],
            'access_view' => $data['access']['access_view'],
            'access_delete' => $data['access']['access_delete'],
            'access_approve' => $data['access']['access_approve'],
            'created_by' => $by,
            'created_at' => date('Y-m-d H:i:s'),
        );
        if(Self::insert($add)){
            return true;
        }else{
            return false;
        }
    }

    public static function updateEmployeeApproveMenuStatus($id, $cusId, $status){
        $menu = array(48,49);
        $menuApproval = array('active' => $status, 'active' => $status);
        $updateMenu = Self::where('account_id', $id)->where('cus_id', $cusId)->whereIn('menu_id', $menu)->update($menuApproval);
        return $updateMenu;
    }

}
