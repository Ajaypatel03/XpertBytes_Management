<?php

namespace App\Http\Controllers;

use App\Models\BoardMember;
use App\Models\Client;
use App\Models\Employ;
use App\Models\Entry;
use App\Models\Expense;
use App\Models\Salary;
use Illuminate\Http\Request;


class EntriesController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::all();
        $boardMembers = BoardMember::all();
        $employees = Employ::all();

        $entries = Entry::query();

        if ($request->filled('from_date')) {
            $entries->where('date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $entries->where('date', '<=', $request->input('to_date'));
        }

        if ($request->filled('management_id')) {
            $entries->where('management_id', $request->input('management_id'));
        }

        $entries = $entries->simplePaginate(10);

        return view('entries', compact('clients', 'boardMembers', 'employees', 'entries'));
    }


    public function create()
    {
        //
    }

  
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'type_of_entry' => 'required',
            'amount' => 'required|numeric',
            'remark' => 'nullable|string',
        ]);

        $id = null;
        switch ($validatedData['type_of_entry']) {
            case '0': // Client
                $id = $request->input('client_id');
                break;
            case '1': // Salary
                $id = $request->input('employ_id');
                break;
            case '2': // Expense
                $id = $request->input('type_of_entry');
                break;
            case '3': // Debt
                $id = $request->input('board_member_id');
                break;
            case '4': // Investment
                $id = $request->input('board_member_id');
                break;
            default:
                // Handle default case
                break;
        }
        $entry = Entry::create([
            'date' => $request->date,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'management_id' => $validatedData['type_of_entry'] ,
            'type_of_entry' => $id,
        ]);

        $request->session()->flash('alert-success', 'Entry Added Successfully');
        return redirect()->route('entries.index');
    }



    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $entry = Entry::with(['client', 'employ', 'boardMember'])
                        ->findOrFail($id);

        // Add a subquery to fetch the client ID if management_id is 0
        if ($entry->management_id == 0) {
            $entry->client_id = Client::where('deleted_at', null)
                                    ->where('id', $entry->type_of_entry)
                                    ->value('id');
        } elseif ($entry->management_id == 1) {
            $entry->employ_id = Employ::where('deleted_at', null)
                                    ->where('id', $entry->type_of_entry)
                                    ->value('id');
        } elseif (in_array($entry->management_id, [3, 4])) {
            $entry->board_member_id = BoardMember::where('deleted_at', null)
                                        ->where('id', $entry->type_of_entry)
                                        ->value('id');
        }

        return response()->json($entry);
    }



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'type_of_entry' => 'required',
            'amount' => 'required|numeric',
            'remark' => 'nullable|string',
        ]);

        $entry = Entry::find($id);

        if (!$entry) {
            abort(404);
        }

        $id = null;
        switch ($validatedData['type_of_entry']) {
            case '0': // Client
                $id = $request->input('client_id');
                break;
            case '1': // Salary
                $id = $request->input('employ_id');
                break;
            case '2': // Expense
                $id = $request->input('type_of_entry');
                break;
            case '3': // Debt
                $id = $request->input('board_member_id');
                break;
            case '4': // Investment
                $id = $request->input('board_member_id');
                break;
            default:
                // Handle default case
                break;
        }

        $entry->update([
            'date' => $request->date,
            'amount' => $request->amount,
            'remark' => $request->remark,
            'management_id' => $validatedData['type_of_entry'],
            'type_of_entry' => $id,
        ]);

        return response()->json();
    }


    public function destroy($id)
    {
       $entries = Entry::find($id);

        if(!$entries){
            abort(404);
        }

        $entries->delete();

        request()->session()->flash('alert-success','Entry Deleted Successfully');

        return redirect()->route('entries.index');
    }
}