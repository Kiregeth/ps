<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\app_form;
use App\new_databank;


class NewDbController extends Controller
{
    public function new_databank(Request $request)
    {
        $sel="";
        $search="";

        $app_cols=\Schema::getColumnListing('app_forms');
        $db_cols=\Schema::getColumnListing('new_databanks');

        $datas= \DB::table('app_forms')
            ->join('new_databanks', 'app_forms.ref_no', '=', 'new_databanks.ref_no')
            ->paginate(20);


        return view("joins.new_databank",compact('app_cols','db_cols','sel','search','datas'));
    }

    public function getByPage($page = 1, $limit = 10)
    {
        $results = \StdClass;
        $results->page = $page;
        $results->limit = $limit;
        $results->totalItems = 0;
        $results->items = array();

        $users = $this->model->skip($limit * ($page - 1))->take($limit)->get();

        $results->totalItems = $this->model->count();
        $results->items = $users->all();

        return $results;
    }
}
