<?php

namespace App\Http\Controllers;

use App\Helpers\Helper as Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\MenuSetting;

class MenuSettingController extends Controller
{
    /* get menu sesuai customer */
    public function index(Request $request)
    {
        // default zone
        date_default_timezone_set('Asia/Jakarta');

        if (isset($request->token)) {
            $userActive = User::userActive($request->token);
            if ($userActive) {
                $userToken = User::userByToken($request->token);

                if (!empty($userToken)) {
                    $getMenu = MenuSetting::getHeader($userToken->id);

                    if (!empty($getMenu)) {
                        $menu = [];

                        foreach ($getMenu as $value) {
                            $menu[$value->title] = array(
                                'menu_id' => md5($value->id),
                                'path' => $value->path,
                                'title' => $value->title,
                                'icon' => $value->icon,
                                'class' => $value->class,
                                'routerLinkActive' => $value->routerLinkActive,
                                'mMenuLinkRedirect' => $value->mMenuLinkRedirect,
                                'mMenuSubmenuToggle' => $value->mMenuSubmenuToggle,
                                'submenu' => []
                            );
                            
                            $itemChild = array(
                                'menu_id' => $value->id,
                                'user_id' => $value->user_id,
                            );

                            $getChild = MenuSetting::getChild($itemChild);

                            if (!empty($getChild)) {
                                foreach ($getChild as $item) {
                                    $menu[$value->title]['submenu'][] = array(
                                        'menu_id' => md5($value->id),
                                        'path' => $item->path,
                                        'title' => $item->title,
                                        'icon' => $item->icon,
                                        'class' => $item->class,
                                        'routerLinkActive' => $item->routerLinkActive,
                                        'mMenuLinkRedirect' => $item->mMenuLinkRedirect,
                                        'mMenuSubmenuToggle' => $item->mMenuSubmenuToggle,
                                        'submenu' => []
                                    );
                                }
                            }
                        }
                        
                        $data = Helper::_success();
                        $data['data'] = array_values($menu);

                    } else {
                        $data = Helper::_badRequest();
                        $data['message_detail'] = 'Failed request, Please try again';
                    }

                } else {
                    $data = Helper::_sessionExpired();
                }
            } else {
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_noToken();
        }

        return response()->json($data, 200);
    }

    public function checkMenuAccess(Request $request)
    {
        // timezone
        date_default_timezone_set('Asia/Jakarta');

        if (isset($request->token)) {
            $userActive = User::userActive($request->token);
            if($userActive){
                $user = User::userByToken($request->token);
    
                if (!empty($user)) {
                    $content = array(
                        'user_id'    => $user->id,
                        'path'          => $request->path
                    );
                    $getData = MenuSetting::getMenuPath($content);
    
                    if($getData){
                        $data = Helper::_success();
                        $data['data'] = $getData;
                    }else{
                        $data = Helper::_badRequest();
                    }
                } else {
                    $data = Helper::_getDataIfSessionExpired();
                }
            }else{
                $data = Helper::_badRequest();
                $data['message_detail'] = "Your account is not active!";
            }
        } else {
            $data = Helper::_getDataIfNoToken();
        }

        return response()->json($data, 200);
    }

}
