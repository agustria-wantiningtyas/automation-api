<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $table = 'tm_test_case';
    protected $primaryKey = 'id';
    public $timestamps = false;

    private $_index = "*";

    public function getAllData($content)
    {

        $q = Self::selectraw('tm_test_case.id, tm_test_case.name, tm_test_case.status, created_at')
            ->where('tm_test_case.user_id', $content['user_id'])
            ->where('tm_test_case.status', $content['status'])
            ->orderByRaw('tm_test_case.' . $content['order'] . ' ' . $content['sortOrder']);
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
        return $data;
    }

    public static function show($id)
    {
        return Self::where('id', $id)->first();
    }

    public static function showByStatus($user_id)
    {
        return Self::where('status', 'Y')->where('user_id', $user_id)->get();
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
