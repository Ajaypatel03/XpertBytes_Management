<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvestmentRequest;
use App\Models\BoardMember;
use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investment = Investment::simplePaginate(10);
        $boardMembers = BoardMember::all();
        return view('investment',compact('investment','boardMembers'));
    }

    public function create()
    {
        //
    }

    public function store(InvestmentRequest $request)
    {
        $investment = Investment::create([

                'date'=>$request->date,
                'board_members_id'=>$request->board_members_id,
                'amount'=>$request->amount,
                'remark'=>$request->remark,
        ]);       

               $request->session()->flash('alert-success','Investment Entry Added Successfully');
               // return to_route('posts.index');
                return redirect()->route('invest.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $investment = Investment::findOrFail($id);
        return response()->json($investment);
    }

    public function update(InvestmentRequest $request, $id)
    {
        $investment = Investment::find($id);

        if (!$investment) {
            abort(404);
        }

        $investment->update([
            
            'date'=>$request->date,
            'board_members_id'=>$request->board_members_id,
            'amount'=>$request->amount,
            'remark'=>$request->remark,
        ]);

        return response()->json();
    }

    public function destroy($id)
    {
       $investment = Investment::find($id);

        if(!$investment){
            abort(404);
        }

        $investment->delete();

        request()->session()->flash('alert-success','Investment Entry Deleted Successfully');

        return redirect()->route('invest.index');
    }
}