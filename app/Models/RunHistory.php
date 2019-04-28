<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RunHistory extends Model
{
    protected $table = 't_run_history';
    protected $primaryKey = 'id';
    public $timestamps = false;

    private $_index = "*";

    public function getAllData($content)
    {

        $q = Self::selectraw('t_run_history.id, b.name, b.status, t_run_history.created_at, t_run_history.path_url')
            ->join('tm_test_case as b', 't_run_history.test_case_id', '=', 'b.id')
            ->where('b.user_id', $content['user_id'])
            ->where('b.status', $content['status'])
            ->orderByRaw('t_run_history.' . $content['order'] . ' ' . $content['sortOrder']);
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
        $q = Self::selectraw('t_run_history.id, b.name, b.status, t_run_history.created_at')
            ->join('tm_test_case as b', 't_run_history.test_case_id', '=', 'b.id')
            ->where('b.user_id', $content['user_id'])
            ->where('b.status', $content['status'])
            ->whereMonth('t_run_history.created_at', '=', $content['month'])
            ->whereYear('t_run_history.created_at', '=', $content['year'])
            ->orderByRaw("t_run_history.created_at ASC");

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
            $data->where('b.name', 'like', '%' . $filters['name']['value'] . '%');
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
