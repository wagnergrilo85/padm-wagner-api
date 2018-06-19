<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StateController extends Controller
{
    public function index()
    {
        $states = DB::table('ad_states')
            ->orderBy('uf', 'asc')
            ->get();
        
        return $states;
//        return State::all();
    }

    public function store(Request $request)
    {
        return State::create($request->all());
    }

    public function show(State $state)
    {
        return $state;
    }

    public function update(Request $request, State $state)
    {
        $state->update($request->all());
        return $state;
    }

    public function destroy(State $state)
    {
        $state->delete();
        return $state;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>'id',
            1 =>'state',
            2 =>'uf',
        );

        $totalData = State::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {
            $States = State::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $sql =  State::where('id','LIKE',"%{$search}%")
                ->orWhere('state', 'LIKE',"%{$search}%")
                ->orWhere('uf', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = State::where('id','LIKE',"%{$search}%")
                ->orWhere('state', 'LIKE',"%{$search}%")
                ->orWhere('uf', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $States = $sql;

            $totalFiltered = State::where('id','LIKE',"%{$search}%")
                ->orWhere('state', 'LIKE',"%{$search}%")
                ->orWhere('uf', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($States))
        {
            foreach ($States as $state)
            {
                $nestedData['id']       = $state->id;
                $nestedData['state']    = $state->state;
                $nestedData['uf']       = $state->uf;

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
