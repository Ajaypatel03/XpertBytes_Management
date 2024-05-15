<?php

namespace App\Http\Controllers;

use App\Http\Requests\SalaryRequest;
use App\Models\Employ;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function index()
    {
       $salaries = Salary::simplePaginate(10);
       $employs = Employ::all();
       return view('salary',compact('salaries','employs'));
    }

    public function create()
    {
        //
    }

    public function store(SalaryRequest $request)
    {
        $salary = Salary::create([

                'date'=>$request->date,
                'employ_id'=>$request->employ_id,
                'salary'=>$request->salary,
                'remark'=>$request->remark,
        ]);       

               $request->session()->flash('alert-success','Salary Added Successfully');
               // return to_route('posts.index');
                return redirect()->route('salaries.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $salary = Salary::findOrFail($id);
        return response()->json($salary);
    }

    public function update(SalaryRequest $request, $id)
    {
       $salary = Salary::find($id);

        if (!$salary) {
            abort(404);
        }

        $salary->update([
            
            'date'=>$request->date,
            'employ_id'=>$request->employ_id,
            'salary'=>$request->salary,
            'remark'=>$request->remark,
        ]);

        return response()->json();
    }

    public function destroy($id)
    {
        $salary = Salary::find($id);

        if(!$salary){
            abort(404);
        }

        $salary->delete();

        request()->session()->flash('alert-success','Salary Deleted Successfully');

        return redirect()->route('salaries.index');
    }
}