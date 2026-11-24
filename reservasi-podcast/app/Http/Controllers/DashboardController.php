<?php

namespace App\Http\Controllers;

use App\Services\KalenderService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, KalenderService $kalender)
    {
        return view('dashboard', $kalender->susun($request));
    }
}