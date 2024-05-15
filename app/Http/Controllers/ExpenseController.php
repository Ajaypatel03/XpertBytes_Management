<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::simplePaginate(10);
        return view('expense',compact('expenses'));
    }

    public function create()
    {
        //
    }

    public function store(ExpenseRequest $request)
    {
        $expense = Expense::create([

                'date'=>$request->date,
                'amount'=>$request->amount,
                'remark'=>$request->remark,
        ]);       

               $request->session()->flash('alert-success','Expense Added Successfully');
               // return to_route('posts.index');
                return redirect()->route('expenses.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $expense = Expense::findOrFail($id);
        return response()->json($expense);
    }

    public function update(ExpenseRequest $request, $id)
    {
        $expense = Expense::find($id);

        if (!$expense) {
            abort(404);
        }

        $expense->update([
            
            'date'=>$request->date,
            'amount'=>$request->amount,
            'remark'=>$request->remark,
        ]);

        return response()->json();
    }

    public function destroy($id)
    {
        $expense = Expense::find($id);

        if(!$expense){
            abort(404);
        }

        $expense->delete();

        request()->session()->flash('alert-success','Expense Deleted Successfully');

        return redirect()->route('expenses.index');
    }
}