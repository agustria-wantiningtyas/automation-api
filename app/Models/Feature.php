<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'tm_feature';
    protected $primaryKey = 'id';
    public $timestamps = false;

    private $_index = "*";

    public function getAllData($content)
    {

        $q = Self::where('status', $content['status'])
            ->orderByRaw($content['order'] . ' ' . $content['sortOrder']);
        // filter
        $q = $this->_filterData($q, $content['filters']);
        // total records
        $count = $q->count();
        // limit
        $q->skip($content['skip'])->take($content['limit']);
        // response
        $result = array(
            'data' => $q->get(),
            'count' => $count,
        );
        return $result;
    }

    public function getAllDataExport($content)
    {
        $q = Self::selectRaw($this->_index)
            ->where('status', $content['status'])
            ->orderByRaw("name ASC");

        // total records
        $count = $q->count();
        // response
        $result = array(
            'data' => $q->get(),
            'count' => $count,
        );

        return $result;
    }

    public static function _filterData($data, $filters)
    {
        if (!empty($filters['name'])) {
            $data->where('name', 'like', '%' . $filters['name']['value'] . '%');
        }

        if (!empty($filters['gender'])) {
            $data->whereIn('gender', $filters['gender']['value']);
        }

        if (!empty($filters['no_telp'])) {
            $data->where('no_telp', 'like', '%' . $filters['no_telp']['value'] . '%');
        }

        if (!empty($filters['email'])) {
            $data->where('email', 'like', '%' . $filters['email']['value'] . '%');
        }

        return $data;
    }

    public static function show($id)
    {
        return Self::where('id', $id)->first();
    }

    public static function store($data)
    {
        return Self::insert($data);
    }

    public static function edit($content)
    {
        $q = Self::find($content['id']);
        $q->name = $content['name'];
        $q->status = $content['status'];
        $q->updated_at = date('Y-m-d H:i:s');

        return $q->update();
    }

    public static function actionDelete($content)
    {
        date_default_timezone_set('Asia/Jakarta');
        $q = Self::find($content['id']);
        $q->status = $content['status'];
        $q->deleted_by = $content['deleted_by'];
        $q->deleted_at = date('Y-m-d H:i:s');
        return $q->update();
    }
}
