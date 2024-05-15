<?php

namespace App\Http\Controllers;

use App\Http\Requests\BoardMemberRequest;
use App\Models\BoardMember;
use Illuminate\Http\Request;

class BoardMemberController extends Controller
{
    public function index()
    {
        $boardMembers = BoardMember::simplePaginate(10);
        return view('board_members',compact('boardMembers'));
    }

    public function create()
    {
        //
    }

    public function store(BoardMemberRequest $request)
    {
         $boardMembers = BoardMember::create([

                'name'=>$request->name,
                'designation'=>$request->designation,
                'mobile_no'=>$request->mobile_no,
                'email'=>$request->email,
        ]);       

               $request->session()->flash('alert-success','Member Added Successfully');
               // return to_route('posts.index');
                return redirect()->route('boardMembers.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $boardMembers = BoardMember::findOrFail($id);
        return response()->json($boardMembers);
    }

    public function update(BoardMemberRequest $request, $id)
    {
        $boardMembers = BoardMember::find($id);

        if (!$boardMembers) {
            abort(404);
        }

        $boardMembers->update([
            
            'name' => $request->name,
            'designation' => $request->designation,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
        ]);

        return response()->json();
    }

    public function destroy($id)
    {
        $boardMembers = BoardMember::find($id);

        if(!$boardMembers){
            abort(404);
        }

        $boardMembers->delete();

        request()->session()->flash('alert-success','Member Deleted Successfully');

        return redirect()->route('boardMembers.index');
    }
}