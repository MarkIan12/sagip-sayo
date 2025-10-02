<?php

namespace App\Http\Controllers;

use App\IncidentType;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = IncidentType::query();

        if ($request->filled('search')) { // use filled() instead of has() to check not empty
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $incident_types = $query->paginate(10)->appends($request->all()); // preserve search in pagination
        return view('incident_types.index', compact('incident_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $incident_type = new IncidentType();
        $incident_type->name     = $request->name;
        $incident_type->created_by = auth()->user()->id;;
        $incident_type->save(); 
        
        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IncidentType  $incidentType
     * @return \Illuminate\Http\Response
     */
    public function show(IncidentType $incidentType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IncidentType  $incidentType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $incident_type = IncidentType::findOrFail($id);
        return array(
            'name' => $incident_type->name,
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IncidentType  $incidentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $incident_type = IncidentType::findOrFail($id);
        $incident_type->name = $request->name;
        $incident_type->save();

        Alert::success('Successfully Update')->persistent('Dismiss');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IncidentType  $incidentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $incident_type = IncidentType::findOrFail($request->id);
        $incident_type->delete();

        Alert::success('Successfully Deleted')->persistent('Dismiss');
        return back();
    }
}
