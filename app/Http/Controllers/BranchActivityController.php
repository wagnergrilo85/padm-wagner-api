<?php

namespace App\Http\Controllers;

use App\BranchActivity;
use Illuminate\Http\Request;

class BranchActivityController extends Controller
{

    public function index()
    {
        return BranchActivity::all();
    }

    public function store(Request $request)
    {
        return BranchActivity::create($request->all());
    }

    public function show(BranchActivity $activity)
    {
        return $activity;
    }

    public function update(Request $request, BranchActivity $activity)
    {
        $activity->update($request->all());
        return $activity;
    }

    public function destroy(BranchActivity $activity)
    {
        $activity->delete();
        return $activity;
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

        $totalData = BranchActivity::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {
            $branchActivities = BranchActivity::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $sql =  BranchActivity::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('classification', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = BranchActivity::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $branchActivities = $sql;

            $totalFiltered = BranchActivity::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($Clients))
        {
            foreach ($branchActivities as $branchActivity)
            {
                $nestedData['id']       = $branchActivity->id;
                $nestedData['name']     = $branchActivity->name;
                $nestedData['classification']     = $branchActivity->classification;
                $nestedData['status']   = $branchActivity->status;

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
