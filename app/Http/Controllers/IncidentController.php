<?php

namespace App\Http\Controllers;
use App\Incident;
use App\Barangay;
use App\Street;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    //
    public function index(Request $request)
    {
        $incidents = Incident::with('persons')
            ->when($request->barangay, function ($q) use ($request) {
                $q->where('barangay', $request->barangay);
            })
            ->when($request->street, function ($q) use ($request) {
                $q->where('street', 'LIKE', "%{$request->street}%");
            })
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('type_of_incident', 'LIKE', "%{$request->search}%")
                        ->orWhere('description', 'LIKE', "%{$request->search}%")
                        ->orWhere('designation_office', 'LIKE', "%{$request->search}%");
                });
            })
            ->orderBy('date_time', 'desc')
            ->paginate(10) // ✅ Laravel pagination
            ->appends($request->query()); // keep filters in pagination links

        $barangays = Barangay::get();
        $streets   = Street::get();

        return view('incidents.index', compact('incidents', 'barangays', 'streets'));
    }
      public function create()
    {
        return view('incidents.create');
    }
}
