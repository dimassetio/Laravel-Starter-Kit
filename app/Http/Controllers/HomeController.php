<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Sale;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch unique years from the sales data
        $years = Sale::select(DB::raw('YEAR(sale_date) as year'))
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Get the sales data for the current year by default
        $currentYear = date('Y');
        // $monthlySales = $this->getMonthlySales($currentYear);

        return view('pages.home', compact('years'));
    }
}
