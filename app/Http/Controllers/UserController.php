<?php

namespace App\Http\Controllers;

use App\Helpers\Helper as Helper;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /* BEGIN LOGIN DEV */
    public function login(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        $email = $request->has('email') ? $request->email : '';
        $password = $request->has('password') ? $request->password : '';

        $content = array(
            'email' => $email,
            'password' => md5($password),
            'status' => 'Y',
        );

        $_login = User::getLogin($content);

        if (!empty($_login)) {
            $token = $this->_setToken($_login);

            $data = Helper::_success();
            $data['message_detail'] = 'Login successfully';
            $data['data'] = [
                'user_id' => $_login->id,
                'token' => $token,
                'email' => $_login->email,
                'emp_id' => $_login->emp_id,
            ];

        } else {
            $data = Helper::_badRequest();
            $data['message_detail'] = 'Email or Password is incorrect';
        }
        return response()->json($data, 200);
    }

    public function _setToken($_login)
    {
        date_default_timezone_set('Asia/Jakarta');
        $token = $_login->id . str_random(40);

        if (empty($_login->token)) {
            $content = [
                "user_id" => $_login->id,
                "token" => $token,
            ];
            $setToken = User::setToken($content);
            if ($setToken) {
                $_token = $token;
            } else {
                $_token = '';
            }
        } else {
            $_token = $_login->token;
        }

        return $_token;
    }
    /* END LOGIN DEV */
}
