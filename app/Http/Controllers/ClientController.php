<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::simplePaginate(10);
        return view('client',compact('clients'));
    }

    public function create()
    {
        //
    }

    public function store(ClientRequest $request)
    {
        $client = Client::create([

                'name'=>$request->name,
                'mobile_no'=>$request->mobile_no,
                'email'=>$request->email,
                'address'=>$request->address,
                'description'=>$request->description,

        ]);       

               $request->session()->flash('alert-success','Client Added Successfully');
               // return to_route('posts.index');
                return redirect()->route('clients.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
    }

    public function update(ClientRequest $request, $id)
    {
        $client = Client::find($id);

        if (!$client) {
            abort(404);
        }

        $client->update([
            
            'name'=>$request->name,
            'mobile_no'=>$request->mobile_no,
            'email'=>$request->email,
            'address'=>$request->address,
            'description'=>$request->description,
        ]);

        return response()->json();
    }

    public function destroy($id)
    {
        $client = Client::find($id);

        if(!$client){
            abort(404);
        }

        $client->delete();

        request()->session()->flash('alert-success','Client Deleted Successfully');

        return redirect()->route('clients.index');
    }
}