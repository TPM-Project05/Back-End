<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB; 
use App\Models\User;
use App\Models\Leader;

use Illuminate\view\View;
use Illuminate\Support\Facades\Route;
class DashboardController extends Controller
{
    
    function users() {
        return DB::select('select * from users');
    }

    public function leaders() {
        return DB::select('select * from leaders');
    }

    public function index() {
        $leaders = Leader::all();
        $users = User::all();


        // Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');


        return view('dashboard', compact('leaders', 'users'));
        // return view('leaders',['leaders' => $leaders],['users' => $users]);
    // return view('dashboard',['leaders' => $leaders],['users' => $users]);
    }
}
