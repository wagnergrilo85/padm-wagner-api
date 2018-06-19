<?php

namespace App\Http\Controllers;

use App\ClientGroup;
use Illuminate\Http\Request;

class ClientGroupController extends Controller
{
    public function index()
    {
        return ClientGroup::all();
    }

    public function store(Request $request)
    {
        return ClientGroup::create($request->all());
    }

    public function show(ClientGroup $clientGroup)
    {
        return $clientGroup;
    }

     public function update(Request $request, ClientGroup $clientGroup)
    {
        $clientGroup->update($request->all());
        return $clientGroup;
    }

    public function destroy(ClientGroup $clientGroup)
    {
        $clientGroup->delete();
        return $clientGroup;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'classification',
            3 =>'created_at',
            4 =>'status',
        );

        $totalData = ClientGroup::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {
            $clientGroups = ClientGroup::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $sql =  ClientGroup::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('classification', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = ClientGroup::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('classification', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $clientGroups = $sql;

            $totalFiltered = ClientGroup::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('classification', 'LIKE',"%{$search}%")
                ->orWhere('created_at', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($clientGroups))
        {
            foreach ($clientGroups as $clientGroup)
            {
                $nestedData['id']           = $clientGroup->id;
                $nestedData['name']         = $clientGroup->name;
                $nestedData['status']       = $clientGroup->status;
                $nestedData['created_at']   = $clientGroup->created_at;

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
