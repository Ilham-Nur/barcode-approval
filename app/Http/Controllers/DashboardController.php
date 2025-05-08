<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {

         // Dummy data
        $summary = [
            'project_pending' => 8,
            'project_approve_needed' => 3,
            'total_employees' => 27,
        ];

        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'data' => [5, 3, 6, 8, 4, 9, 7, 6, 5, 10, 8, 4],
        ];

        return view('dashboard.dashboard', compact('summary', 'chartData'));
    }
}
