<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Incident;
use App\Barangay;
use App\IncidentType;
use App\Street;

class IncidentReportController extends Controller
{
    //
   public function index(Request $request)
{
    $from = $request->input('from');
    $to = $request->input('to');
    $barangay = $request->input('barangay');
    $street = $request->input('street');
    $type = $request->input('type');

    // Query incidents
    $incidents = Incident::with(['barangay', 'type', 'street'])
        ->when($from, fn($q) => $q->whereDate('date', '>=', $from))
        ->when($to, fn($q) => $q->whereDate('date', '<=', $to))
        ->when($barangay, fn($q) => $q->where('barangay_id', $barangay))
        ->when($street, fn($q) => $q->where('street_id', $street))
        ->when($type, fn($q) => $q->where('type_of_incident', $type))
        ->get();

    // Streets list filtered by selected barangay
    $streets = Street::get();
                // dd($streets);

    // Prepare chart data
    $barData = [
        'labels' => $incidents->groupBy(fn($i) => $i->barangay->name ?? 'N/A')->keys()->toArray(),
        'counts' => $incidents->groupBy(fn($i) => $i->barangay->name ?? 'N/A')->map->count()->values()->toArray(),
    ];

    $pieData = [
        'labels' => $incidents->groupBy(fn($i) => $i->typeOfIncident->name ?? 'N/A')->keys()->toArray(),
        'counts' => $incidents->groupBy(fn($i) => $i->typeOfIncident->name ?? 'N/A')->map->count()->values()->toArray(),
    ];

    $barangays = Barangay::all();
    $types = IncidentType::all();

    return view('incidents.report', [
        'incidents' => $incidents,
        'barData'   => $barData,
        'pieData'   => $pieData,
        'barangays' => $barangays,
        'types'     => $types,
        'from'      => $from,
        'to'        => $to,
        'barangay'  => $barangay,
        'street'    => $street,
        'streets'   => $streets,
        'type'      => $type,
    ]);
}
}
