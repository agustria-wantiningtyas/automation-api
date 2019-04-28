<?php

namespace App\Helpers;
use GuzzleHttp\Client;
use DateTime;
use DateInterval;
use DatePeriod;

class DataService
{
    public static function _attendanceService($request){
        return app('App\Http\Controllers\AttendanceController')->attendanceData($request);
    }

    public static function _userService($request){
        return app('App\Http\Controllers\MemberController')->memberSelectbox($request);
    }

    public static function _allUserService($request){
        return app('App\Http\Controllers\MemberController')->getAllMember($request);
    }
}
