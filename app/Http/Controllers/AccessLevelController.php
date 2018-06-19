<?php

namespace App\Http\Controllers;

use App\AccessLevel;
use Illuminate\Http\Request;

class AccessLevelController extends Controller
{

    public function index()
    {
        return AccessLevel::all();
    }

    public function store(Request $request)
    {
//        return $request->all();
        return AccessLevel::create($request->all());
    }


    public function show(AccessLevel $accessLevel)
    {
        return $accessLevel;
    }

    public function update(Request $request, AccessLevel $accessLevel)
    {
        $accessLevel->update($request->all());
        return $accessLevel;
    }

    public function destroy(AccessLevel $accessLevel)
    {
        $accessLevel->delete();
        return $accessLevel;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'mod_financial',
            3 =>'mod_client',
            4 =>'mod_user',
            5 =>'mod_product',
            6 =>'mod_service',
            7 =>'mod_plan',
            8 =>'mod_report',
            9 =>'mod_config',
            10 =>'access_type',
            11 =>'status',
        );

        $totalData = AccessLevel::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {
            $accessLeves = AccessLevel::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $sql =  AccessLevel::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = AccessLevel::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $accessLeves = $sql;

            $totalFiltered = AccessLevel::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($accessLeves))
        {
            foreach ($accessLeves as $accessLeve)
            {
                $nestedData['id']               = $accessLeve->id;
                $nestedData['name']             = $accessLeve->name;
                $nestedData['mod_financial']    = $accessLeve->mod_financial;
                $nestedData['mod_client']       = $accessLeve->mod_client;
                $nestedData['mod_user']         = $accessLeve->mod_user;
                $nestedData['mod_product']      = $accessLeve->mod_product;
                $nestedData['mod_service']      = $accessLeve->mod_service;
                $nestedData['mod_plan']         = $accessLeve->mod_plan;
                $nestedData['mod_report']       = $accessLeve->mod_report;
                $nestedData['mod_config']       = $accessLeve->mod_config;
                $nestedData['access_type']      = $accessLeve->access_type;
                $nestedData['status']           = $accessLeve->status;

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
