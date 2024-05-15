<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function openProfilePage()
    {
        $user = auth()->user();
        return view('myProfile',compact('user'));
    }

    public function storeProfilePage(Request $request)
    {
    $user = auth()->user();

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    $request->session()->flash('alert-success', 'Profile Updated Successfully');

    return redirect()->route('profile');

    }

}