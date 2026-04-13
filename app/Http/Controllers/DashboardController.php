<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\SystemHistory;
use App\Models\Attendance;
use App\Models\Financial;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboardindex()
    {
        $user = auth()->user();

        $totalStudents  = Student::count();
        $activeStudents = Student::where('status', 'Active')->count();
        $newEnrollments = Student::whereMonth('created_at', now()->month)
                                 ->whereYear('created_at', now()->year)
                                 ->count();

        $enrollmentTrend = $this->getEnrollmentTrend(6);
        $deptDistribution = $this->getDepartmentDistribution();
        $attendanceSummary = $this->getAttendanceSummary();
        $financialSummary = $this->getFinancialSummary();
        $failedAttendance = $this->getFailedAttendanceStats();
        $failedScores = $this->getFailedScoresStats();

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
            'enrollmentTrend',
            'deptDistribution',
            'attendanceSummary',
            'financialSummary',
            'failedAttendance',
            'failedScores',
        ));
    }

    private function getEnrollmentTrend($months = 6)
    {
        $newEnrollments = [];
        $totalStudents = [];
        $labels = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M Y');
            
            // New enrollments for this month
            $newCount = Student::whereMonth('created_at', $date->month)
                               ->whereYear('created_at', $date->year)
                               ->count();
            $newEnrollments[] = $newCount;
            
            // Total students up to end of this month
            $totalCount = Student::whereDate('created_at', '<=', $date->endOfMonth())->count();
            $totalStudents[] = $totalCount;
        }

        return [
            'labels' => $labels,
            'newEnrollments' => $newEnrollments,
            'totalStudents' => $totalStudents
        ];
    }

    private function getDepartmentDistribution()
    {
        // Get student status distribution breakdown
        $statusCounts = Student::select('status', DB::raw('count(*) as count'))
                              ->groupBy('status')
                              ->get();

        $labels = [];
        $data = [];
        $colorMap = [
            'Active' => '#10B981',      // Green
            'Inactive' => '#F59E0B',    // Amber
            'Graduated' => '#3B82F6',   // Blue
        ];

        foreach ($statusCounts as $status) {
            $labels[] = $status->status;
            $data[] = $status->count;
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'colors' => array_map(fn($label) => $colorMap[$label] ?? '#8B5CF6', $labels),
        ];
    }

    private function getAttendanceSummary()
    {
        return [
            'excellent' => Attendance::where('status', 'Excellent')->count(),
            'good' => Attendance::where('status', 'Good')->count(),
            'average' => Attendance::where('status', 'Average')->count(),
            'critical' => Attendance::where('status', 'Critical')->count(),
        ];
    }

    private function getFinancialSummary()
    {
        return [
            'paid' => Financial::where('payment_status', 'Paid')->count(),
            'partial' => Financial::where('payment_status', 'Partial')->count(),
            'unpaid' => Financial::where('payment_status', 'Unpaid')->count(),
            'overdue' => Financial::where('payment_status', 'Overdue')->count(),
        ];
    }

    private function getFailedAttendanceStats()
    {
        $students = Student::with('attendance')->get();
        $failed = 0;
        $passed = 0;

        foreach ($students as $student) {
            $attendance = $student->attendance;
            if (!$attendance) continue;

            $attendancePercentage = $attendance->total_days > 0
                ? round(($attendance->present_days / $attendance->total_days) * 100)
                : 0;

            if ($attendancePercentage < 75) {
                $failed++;
            } else {
                $passed++;
            }
        }

        return [
            'failed' => $failed,
            'passed' => $passed,
            'total' => $failed + $passed,
        ];
    }

    private function getFailedScoresStats()
    {
        $students = Student::with('scores')->get();
        $studentsFailed = 0;
        $totalStudents = 0;

        foreach ($students as $student) {
            if ($student->scores->isEmpty()) continue;

            $totalStudents++;
            $failedSubjects = $student->scores->where('total_score', '<', 60)->count();

            if ($failedSubjects > 0) {
                $studentsFailed++;
            }
        }

        return [
            'failed' => $studentsFailed,
            'passed' => $totalStudents - $studentsFailed,
            'total' => $totalStudents,
        ];
    }
}