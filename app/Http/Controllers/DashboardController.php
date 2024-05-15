<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\BoardMember;
use App\Models\Client;
use App\Models\Employ;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   public function dashboard()
   {
    $boardMemberscount = BoardMember::count();
    $userscount = User::count();
    $employscount = Employ::count();
    $clientscount = Client::count();
    return view('dashboard',compact('boardMemberscount','userscount','employscount','clientscount'));
    
   }
}