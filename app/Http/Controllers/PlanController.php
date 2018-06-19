<?php

namespace App\Http\Controllers;

use App\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{

    public function index()
    {
        return Plan::all();
    }

    public function store(Request $request)
    {
        return Plan::create($request->all());
    }

    public function show(Plan $plan )
    {
        return $plan;
    }

    public function update(Request $request, Plan $plan)
    {
        $plan->update($request->all());
        return $plan;
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return $plan;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'description',
            3 =>'status',
            4 =>'product_id',
            5 =>'monthly_price',
            6 =>'annual_price',
            7 =>'quarterly_price',
            8 =>'semi_annual_price',
            9 =>'select_period',
            10 =>'due_date',
            11 =>'date_hiring',
            12 =>'days_of_suspension',
        );

        $totalData = Plan::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {
            $plans = Plan::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $sql = Plan::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('description', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = Plan::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('description', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $plans = $sql;

            $totalFiltered = Plan::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('description', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($Clients))
        {
            foreach ($plans as $plan)
            {
                $nestedData['id']                   = $plan->id;
                $nestedData['name']                 = $plan->name;
                $nestedData['status']               = $plan->status;
                $nestedData['description']          = $plan->description;
                $nestedData['product_id']           = $plan->product_id;
                $nestedData['monthly_price']        = $plan->monthly_price;
                $nestedData['annual_price']         = $plan->annual_price;
                $nestedData['quarterly_price']      = $plan->quarterly_price;
                $nestedData['semi_annual_price']    = $plan->semi_annual_price;
                $nestedData['select_period']        = $plan->select_period;
                $nestedData['due_date']             = $plan->due_date;
                $nestedData['date_hiring']          = $plan->date_hiring;
                $nestedData['days_of_suspension']   = $plan->days_of_suspension;

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
