<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployRequest;
use App\Models\Employ;
use Illuminate\Http\Request;

class EmployController extends Controller
{
    public function index()
    {
        $employs = Employ::simplePaginate(10);
        return view('employ',compact('employs'));
    }

    public function create()
    {
        //
    }

    public function store(EmployRequest $request)
    {
        $employ = Employ::create([

                'name'=>$request->name,
                'designation'=>$request->designation,
                'mobile_no'=>$request->mobile_no,
                'email'=>$request->email,
                'date_of_birth'=>$request->date_of_birth,
                'address'=>$request->address,
        ]);       

               $request->session()->flash('alert-success','Employ Added Successfully');
               // return to_route('posts.index');
                return redirect()->route('employs.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $employ = Employ::findOrFail($id);
        return response()->json($employ);
    }

    public function update(EmployRequest $request, $id)
    {
       $employ = Employ::find($id);

        if (!$employ) {
            abort(404);
        }

        $employ->update([
            
            'name'=>$request->name,
            'designation'=>$request->designation,
            'mobile_no'=>$request->mobile_no,
            'email'=>$request->email,
            'date_of_birth'=>$request->date_of_birth,
            'address'=>$request->address,
        ]);

        return response()->json();
    }

    public function destroy($id)
    {
        $employ = Employ::find($id);

        if(!$employ){
            abort(404);
        }

        $employ->delete();

        request()->session()->flash('alert-success','Employ Deleted Successfully');

        return redirect()->route('employs.index');
    }
}