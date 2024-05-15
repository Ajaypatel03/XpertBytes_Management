<?php

namespace App\Http\Controllers;

use App\Http\Requests\DebitRequest;
use App\Models\BoardMember;
use App\Models\Debit;
use Illuminate\Http\Request;

class DebitController extends Controller
{

    public function index()
    {
       $debit = Debit::simplePaginate(10);
       $boardMembers = BoardMember::all();
       return view('debit',compact('debit','boardMembers'));
    }

    public function create()
    {
        //
    }

    public function store(DebitRequest $request)
    {
         $debit = Debit::create([

                'date'=>$request->date,
                'board_members_id'=>$request->board_members_id,
                'amount'=>$request->amount,
                'remark'=>$request->remark,
        ]);       

               $request->session()->flash('alert-success','Debit Entry Added Successfully');
               // return to_route('posts.index');
                return redirect()->route('debit.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $debit = Debit::findOrFail($id);
        return response()->json($debit);
    }

    public function update(DebitRequest $request, $id)
    {
        $debit = Debit::find($id);

        if (!$debit) {
            abort(404);
        }

        $debit->update([
            
            'date'=>$request->date,
            'board_members_id'=>$request->board_members_id,
            'amount'=>$request->amount,
            'remark'=>$request->remark,
        ]);

        return response()->json();
    }

    public function destroy($id)
    {
        $debit = Debit::find($id);

        if(!$debit){
            abort(404);
        }

        $debit->delete();

        request()->session()->flash('alert-success','Debit Entry Deleted Successfully');

        return redirect()->route('debit.index');
    }
}