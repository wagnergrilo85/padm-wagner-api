<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        return Client::all();
    }

    public function store(Request $request)
    {
        return Client::create($request->all());
    }

    public function show(Client $client)
    {
        return $client;
    }

    public function update(Request $request, Client $client)
    {
        $client->update($request->all());
        return $client;
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return $client;
    }

    public function datatables(Request $request){

        $sql = "";

        $columns = array(
            0 =>'id',
            1 =>'name',
            2 =>'document_type',
            3 =>'document',
            4 =>'address',
            5 =>'city_id',
            6 =>'state_id',
            7 =>'zip_code',
            8 =>'complement',
            9 =>'im',
            10 =>'ie',
            11 =>'rg',
            12 =>'number',
            13 =>'email',
            14 =>'site',
            15 =>'telephone',
            16 =>'cellphone',
            17 =>'fax',
            18 =>'group_id',
            19 =>'category_client',
            20 =>'branch_activity',
            21 =>'status',
        );

        $totalData = Client::count();

        $totalFiltered = $totalData;

        $search = $request->input('search.value');
        $limit = $request->input('length');
        $start = $request->input('start');
        $dir = $request->input('order.0.dir');
        $order = $columns[intval($request->input('order.0.column'))];

        if(empty($search))
        {
            $clients = Client::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $sql = Client::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('document_type', 'LIKE',"%{$search}%")
                ->orWhere('document', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $sql_print = Client::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('document_type', 'LIKE',"%{$search}%")
                ->orWhere('document', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->toSql();

            $clients = $sql;

            $totalFiltered = Client::where('id','LIKE',"%{$search}%")
                ->orWhere('name', 'LIKE',"%{$search}%")
                ->orWhere('document_type', 'LIKE',"%{$search}%")
                ->orWhere('document', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($clients))
        {
            foreach ($clients as $client)
            {
                $nestedData['id']               = $client->id;
                $nestedData['name']             = $client->name;
                $nestedData['status']           = $client->status;
                $nestedData['document_type']    = $client->document_type;
                $nestedData['document']         = $client->document;
                $nestedData['address']          = $client->address;
                $nestedData['city_id']          = $client->city_id;
                $nestedData['state_id']         = $client->state_id;
                $nestedData['zip_code']         = $client->zip_code;
                $nestedData['complement']       = $client->complement;
                $nestedData['complement']       = $client->complement;
                $nestedData['im']               = $client->im;
                $nestedData['ie']               = $client->ie;
                $nestedData['rg']               = $client->rg;
                $nestedData['number']           = $client->number;
                $nestedData['email']            = $client->email;
                $nestedData['site']             = $client->site;
                $nestedData['telephone']        = $client->telephone;
                $nestedData['cellphone']        = $client->cellphone;
                $nestedData['fax']              = $client->fax;
                $nestedData['group_id']         = $client->group_id;
                $nestedData['category_client']  = $client->category_client;
                $nestedData['branch_activity']  = $client->branch_activity;

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
