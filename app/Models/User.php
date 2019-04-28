<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public static function getLogin($content)
    {
        return Self::where('email',$content['email'])->where('password',$content['password'])->where('status', $content['status'])->first();
    }

    public static function userByToken($token){
        return Self::where('token',$token)->first();
    }

    public static function userActive($token){
        if(Self::where('token', $token)->where('status', 'Y')->first()){
            return true;
        }else{
            return false;
        }
    }

    public static function setToken($content)
    {
        $q = Self::where('id',$content['user_id'])->first();
        $q->token = $content['token'];
        $q->updated_at = date('Y-m-d H:i:s');
        return $q->save();
    }

    public static function store($data){
        
        if(Self::insert($data)){
            return true;
        }else{
            return false;
        }
    }

    public static function edit($content){
        $q = Self::find($content['id']);
        $q->email = $content['email'];
        $q->status = $content['status'];
        $q->updated_by = $content['updated_by'];
        $q->updated_at =  date('Y-m-d H:i:s');

        return $q->update();
    }

}
