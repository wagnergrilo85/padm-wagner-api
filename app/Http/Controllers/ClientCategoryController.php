<?php

namespace App\Http\Controllers;

use App\ClientCategory;
use Illuminate\Http\Request;

class ClientCategoryController extends Controller
{
    public function index()
    {
        return ClientCategory::all();
    }

    public function store(Request $request)
    {
        return ClientCategory::create($request->all());
    }

    public function show(ClientCategory $clientCategory)
    {
        return $clientCategory;
    }

    public function update(Request $request, ClientCategory $clientCategory)
    {
        $clientCategory->update($request->all());
        return $clientCategory;
    }

    public function destroy(ClientCategory $clientCategory)
    {
        $clientCategory->delete();
        return $clientCategory;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'classification',
            3 =>'status',
        );

        $totalData = ClientCategory::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {
            $clientCategories = ClientCategory::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $sql =  ClientCategory::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('classification', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = ClientCategory::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('classification', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $clientCategories = $sql;

            $totalFiltered = ClientCategory::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('classification', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($Clients))
        {
            foreach ($clientCategories as $clientCategory)
            {
                $nestedData['id']       = $clientCategory->id;
                $nestedData['name']     = $clientCategory->name;
                $nestedData['status']   = $clientCategory->status;

                $data[] = $nestedData;
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data,
            "sql"             => $sql_print
        );

        echo json_encode($json_data);
    }
}
