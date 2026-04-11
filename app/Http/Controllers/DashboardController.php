<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SystemHistory;

class DashboardController extends Controller
{
    public function dashboardindex()
    {
        $user = auth()->user();

        // Stat cards
        $totalStudents  = Student::count();
        $activeStudents = Student::where('status', 'Active')->count();
        $newEnrollments = Student::whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year)
                                 ->count();

        // Recent activities
        $activities = SystemHistory::with('user')
                                   ->latest()
                                   ->take(10)
                                   ->get();

        return view('dashboard.index', compact(
            'user',
            'totalStudents',
            'activeStudents',
            'newEnrollments',
            'activities',
        ));
    }
}