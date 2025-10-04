<?php

namespace App\Http\Controllers;
use App\Incident;
use App\Barangay;
use App\Street;
use App\IncidentType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       // Total incidents
        // Total incidents
        $totalIncidents = Incident::count();

        // Incidents this month
        $thisMonthIncidents = Incident::whereMonth('date', now()->month)
                                    ->whereYear('date', now()->year)
                                    ->count();

        // Average incidents per month (last 12 months)
        $avgPerMonth = round(
            Incident::whereYear('date', now()->year)->count() / 12, 2
        );

        // Barangay incidents (include all barangays even if 0)
        $barangayCounts = Barangay::withCount('incidents')->get();

        // Streets incidents (include all street even if 0)
        $streetCounts = Street::withCount('incidents')->get();

        // Monthly incidents (last 12 months)
        $monthlyIncidents = Incident::selectRaw("DATE_FORMAT(date, '%b %Y') as month")
                                    ->selectRaw("COUNT(*) as count")
                                    ->groupBy('month')
                                    ->orderBy('date')
                                    ->get();

        // Incident types counts
        $incidentTypes = IncidentType::withCount('incidents')->get();
        // dd($incidentTypes);

        // Latest 5 incidents
        $latestIncidents = Incident::with('user','barangay','incident_types')
                                ->orderBy('date', 'desc')
                                ->limit(5)
                                ->get();

        return view('home', compact(
            'totalIncidents', 'thisMonthIncidents', 'avgPerMonth', 
            'barangayCounts', 'monthlyIncidents', 'incidentTypes', 'latestIncidents', 'streetCounts'
        ));
    }
}
