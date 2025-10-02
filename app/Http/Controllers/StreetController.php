<?php

namespace App\Http\Controllers;

use App\Barangay;
use App\Street;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class StreetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Street::query();
        $barangays = Barangay::get();
        if ($request->filled('search')) { // use filled() instead of has() to check not empty
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhereHas('barangay', function ($q2) use ($searchTerm) {
                        $q2->where('name', 'LIKE', '%' . $searchTerm . '%'); 
                    });
            });
        }

        $streets = $query->paginate(10)->appends($request->all()); // preserve search in pagination
        return view('streets.index', compact(['streets', 'barangays']));
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
        $street = new Street();
        $street->name     = $request->name;
        $street->barangay_id = $request->barangay_id;
        $street->created_by = auth()->user()->id;;
        $street->save(); 
        
        Alert::success('Successfully Saved')->persistent('Dismiss');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Street  $street
     * @return \Illuminate\Http\Response
     */
    public function show(Street $street)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Street  $street
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $street = Street::findOrFail($id);

        return array(
            'name' => $street->name,
            'barangay_id' => $street->barangay_id,
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Street  $street
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Street $street)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Street  $street
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $street = Street::findOrFail($request->id);
        $street->delete();

        Alert::success('Successfully Deleted')->persistent('Dismiss');
        return back();
    }
}
