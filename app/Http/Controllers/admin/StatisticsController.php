<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class StatisticsController extends Controller
{
    public function getUserStats(Request $request)
    {
        // Get the filter value or default to 'all-time'
        $filter = $request->input('filter', 'all-time');

        $query = User::where('user_type', 'client');

        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'this-week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;

            case 'this-month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                break;

            case 'previous-month':
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->whereYear('created_at', Carbon::now()->subMonth()->year);
                break;

            case 'last-three-months':
                $query->whereBetween('created_at', [Carbon::now()->subMonths(3)->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;

            case 'this-year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;

            case 'previous-year':
                $query->whereYear('created_at', Carbon::now()->subYear()->year);
                break;

            case 'custom':
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ]);
                } else {
                    return response()->json(['error' => 'Invalid custom date range.'], 400);
                }
                break;

            case 'all-time':
            default:
                // No additional filtering needed
                break;
        }

        // Count the filtered users
        $userCount = $query->count();

        return response()->json(['count' => $userCount]);
    }


    public function getRevenueStats(Request $request)
    {
        // Get the filter value or default to 'all-time'
        $filter = $request->input('filter', 'all-time');

        // Start the query
        $query = User::whereNotNull('price'); // Consider only users with a subscription price

        switch ($filter) {
            case 'today':
                $query->whereDate('package_date', Carbon::today());
                break;

            case 'this-week':
                $query->whereBetween('package_date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;

            case 'this-month':
                $query->whereMonth('package_date', Carbon::now()->month)
                    ->whereYear('package_date', Carbon::now()->year);
                break;

            case 'previous-month':
                $query->whereMonth('package_date', Carbon::now()->subMonth()->month)
                    ->whereYear('package_date', Carbon::now()->subMonth()->year);
                break;

            case 'last-three-months':
                $query->whereBetween('package_date', [Carbon::now()->subMonths(3)->startOfMonth(), Carbon::now()->endOfMonth()]);
                break;

            case 'this-year':
                $query->whereYear('package_date', Carbon::now()->year);
                break;

            case 'previous-year':
                $query->whereYear('package_date', Carbon::now()->subYear()->year);
                break;

            case 'custom':
                $startDate = $request->input('start_date');
                $endDate = $request->input('end_date');

                if ($startDate && $endDate) {
                    $query->whereBetween('package_date', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay(),
                    ]);
                } else {
                    return response()->json(['error' => 'Invalid custom date range.'], 400);
                }
                break;

            case 'all-time':
            default:
                // No additional filtering needed
                break;
        }

        // Calculate the total revenue
        $totalRevenue = $query->sum('price');

        return response()->json(['total_revenue' => $totalRevenue]);
    }



    public function getVisitStats(Request $request)
    {
        // Get the filter value or default to 'all-time'
        $filter = $request->input('filter', 'all-time');

        // Get the visitor's IP address
        $visitorIp = $request->ip();

        // Define the file path where visit counts and IPs will be stored
        $filePath = storage_path('app/visit_stats/visit_count_' . $filter . '.txt');
        $ipFilePath = storage_path('app/visit_stats/visited_ips_' . $filter . '.txt');
        $lastVisitTimeFilePath = storage_path('app/visit_stats/last_visit_time_' . $filter . '.txt');

        // Check if it's time to clear the IPs file (if more than 24 hours have passed)
        if (Storage::exists('visit_stats/last_visit_time_' . $filter . '.txt')) {
            $lastVisitTime = (int) Storage::get('visit_stats/last_visit_time_' . $filter . '.txt');
            $timeElapsed = Carbon::now()->diffInHours(Carbon::createFromTimestamp($lastVisitTime));

            // If more than 24 hours have passed, clear the IP list
            if ($timeElapsed >= 24) {
                Storage::put('visit_stats/visited_ips_' . $filter . '.txt', json_encode([]));
            }
        }

        // Check if the visited IPs file exists and contains valid JSON
        $visitedIps = [];
        if (Storage::exists('visit_stats/visited_ips_' . $filter . '.txt')) {
            // Read the visited IPs from the file
            $fileContent = Storage::get('visit_stats/visited_ips_' . $filter . '.txt');

            // Check if the file content is valid JSON
            $visitedIps = json_decode($fileContent, true);

            // If the file content is not valid JSON, initialize it as an empty array
            if ($visitedIps === null) {
                $visitedIps = [];
            }
        }

        // Check if this IP has already been counted
        if (in_array($visitorIp, $visitedIps)) {
            // If the IP has already been counted, don't increment the visit count
            $visitCount = (int) Storage::get('visit_stats/visit_count_' . $filter . '.txt');
        } else {
            // If it's a new visit, increment the visit count
            if (Storage::exists('visit_stats/visit_count_' . $filter . '.txt')) {
                $visitCount = (int) Storage::get('visit_stats/visit_count_' . $filter . '.txt');
            } else {
                $visitCount = 0;
            }

            // Increment the visit count
            $visitCount++;

            // Store the updated visit count in the file
            Storage::put('visit_stats/visit_count_' . $filter . '.txt', $visitCount);

            // Add this IP to the list of visited IPs
            $visitedIps[] = $visitorIp;

            // Save the list of visited IPs to the file
            Storage::put('visit_stats/visited_ips_' . $filter . '.txt', json_encode($visitedIps));
        }

        // Update the last visit time to now
        Storage::put('visit_stats/last_visit_time_' . $filter . '.txt', Carbon::now()->timestamp);

        // Return the unique visit count
        return response()->json(['count' => $visitCount]);
    }

}
