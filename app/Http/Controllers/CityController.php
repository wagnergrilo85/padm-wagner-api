<?php

namespace App\Http\Controllers;

use App\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{

    public function index()
    {
//        return City::all();
        $cities = DB::table('ad_cities')->orderBy('city', 'asc')->get();
        return $cities;
    }

    public function store(Request $request)
    {
        return City::create($request->all());
    }

    public function show(City $city)
    {
        return $city;
    }

    public function update(Request $request,City $city)
    {
        $city->update($request->all());
        return $city;
    }
    public function destroy(City $city)
    {
        $city->delete();
        return $city;
    }

    public function datatables(Request $request){

        $sql = "";
        $sql_print = "";

        $columns = array(
            0 =>'id',
            1 =>'code',
            2 =>'city',
            3 =>'uf',
        );

        $totalData = City::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {
            $Clients = City::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $sql =  City::where('id','LIKE',"%{$search}%")
                ->orWhere('city', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();


            $sql_print = City::where('id','LIKE',"%{$search}%")
                ->orWhere('city', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $Clients = $sql;

            $totalFiltered = City::where('id','LIKE',"%{$search}%")
                ->orWhere('city', 'LIKE',"%{$search}%")
                ->orWhere('code', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($Clients))
        {
            foreach ($Clients as $Client)
            {
                $nestedData['id']       = $Client->id;
                $nestedData['code']     = $Client->code;
                $nestedData['city']     = $Client->city;
                $nestedData['uf']       = $Client->uf;

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
