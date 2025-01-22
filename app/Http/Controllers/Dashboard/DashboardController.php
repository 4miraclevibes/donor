<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donor;

class DashboardController extends Controller
{
    public function index()
    {
        $donors = Donor::with(['user', 'province', 'city'])->latest()->get();
        return view('dashboard', compact('donors'));
    }
}
