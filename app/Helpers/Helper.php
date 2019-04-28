<?php

namespace App\Helpers;
use GuzzleHttp\Client;
use DateTime;
use DateInterval;
use DatePeriod;
use Barryvdh\DomPDF\Facade as PDF;

class Helper
{
    public static function _success()
    {
        $result = array(
            'response_code' => 200,
            'message' => 'success',
        );
        return $result;

    }

    public static function _created()
    {
        $result = array(
            'response_code' => 201,
            'message' => 'created',
        );
        return $result;
    }

    public static function _noContent()
    {
        $result = array(
            'response_code' => 204,
            'message' => 'No Content',
        );

        return $result;
    }

    public static function _badRequest()
    {
        $result = array(
            'response_code' => 400,
            'message' => 'Bad Request',
        );

        return $result;
    }

    public static function _forbidden()
    {
        $result = array(
            'response_code' => 403,
            'message' => 'Forbidden',
        );

        return $result;
    }

    public static function _notFound()
    {
        $result = array(
            'response_code' => 404,
            'message' => 'Not Found',
        );
        return $result;
    }

    public static function _methodNotAllowed()
    {
        $result = array(
            'response_code' => 405,
            'message' => 'Method Not Allowed',
        );

        return $result;
    }

    public static function _conflict()
    {
        $result = array(
            'response_code' => 409,
            'message' => 'Conflict',
        );

        return $result;
    }

    public static function _internalServerError()
    {
        $result = array(
            'response_code' => 500,
            'message' => 'Internal Server Error',
        );

        return $result;
    }

    public static function _noToken()
    {
        $result = array(
            'response_code' => 405,
            'message' => 'Please provide your token key'
        );
        return $result;
    }

    public static function _sessionExpired()
    {
        $result = array(
            'response_code' => 401,
            'message' => 'Your session expired, Please login to continue'
        );
        return $result;
    }

    public static function _hoursToMinutes($hours)
    {
        if (strstr($hours, ':')) {
            # Split hours and minutes.
            $separatedData = explode(':', $hours);

            $minutesInHours = $separatedData[0] * 60;
            $minutesInDecimals = $separatedData[1];

            $totalMinutes = $minutesInHours + $minutesInDecimals;
        } else {
            $totalMinutes = $hours * 60;
        }

        return $totalMinutes;
    }
}
