<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuSetting extends Model
{
    protected $table = 'menu_setting';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function getHeader($user_id)
    {
        $_menu = Self::selectRaw('menu_setting.id as id, path, title, icon, class, routerLinkActive, mMenuLinkRedirect,mMenuSubmenuToggle,user_id')
            ->where('parent_id', 0)
            ->join('menu_access as b', 'menu_setting.id', '=', 'b.menu_id')
            ->where('status', '=', 1)
            ->where('active', '=', 1)
            // ->where('user_id', '=', $user_id)
            ->orderBy('order', 'ASC');

        return $_menu->get();
    }

    public static function getChild($item)
    {
        $getChild = Self::selectRaw('menu_setting.id as id, path, title, icon, class, routerLinkActive, mMenuLinkRedirect,mMenuSubmenuToggle')
            ->where('parent_id', $item['menu_id'])
            ->join('menu_access as b', 'menu_setting.id', '=', 'b.menu_id')
            ->where('status', '=', 1)
            ->where('active', '=', 1)
            // ->where('user_id', '=', $item['user_id'])
            ->orderBy('order', 'ASC');

        return $getChild->get();
    }

    public static function getMenuPath($res)
    {
        $q = Self::where('path', $res['path'])
            ->join('menu_access as b', 'menu_setting.id', '=', 'b.menu_id')
            ->where('status', '=', 1)
            ->where('active', '=', 1)
            // ->where('user_id', '=', $res['user_id'])
            ->orderBy('order', 'ASC')
            ->first();

        return $q;
    }
}
