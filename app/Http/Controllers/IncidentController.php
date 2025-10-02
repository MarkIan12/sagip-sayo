<?php

namespace App\Http\Controllers;
use App\Incident;
use App\IncidentType;
use App\IncidentAttachment;
use App\IncidentPerson;
use App\Barangay;
use App\Street;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    //
    public function index(Request $request)
    {
        $incidents = Incident::with(['persons', 'incident_types', 'barangay', 'street', 'cornerStreet', 'attachments'])
            // Filter by barangay
            ->when($request->barangay, function ($q) use ($request) {
                $q->where('barangay_id', $request->barangay);
            })
            // Filter by street
            ->when($request->street, function ($q) use ($request) {
                $q->where('street_id', $request->street)
                ->orWhere('corner_street_id', $request->street);
            })
            // Global search
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->whereHas('incidentType', function ($q2) use ($request) {
                        $q2->where('name', 'LIKE', "%{$request->search}%");
                    })
                    ->orWhere('description', 'LIKE', "%{$request->search}%")
                    ->orWhere('designation_office', 'LIKE', "%{$request->search}%")
                    ->orWhereHas('barangay', function ($q3) use ($request) {
                        $q3->where('name', 'LIKE', "%{$request->search}%");
                    })
                    ->orWhereHas('street', function ($q4) use ($request) {
                        $q4->where('name', 'LIKE', "%{$request->search}%");
                    });
                });
            })
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10)
            ->appends($request->query());

        $barangays = Barangay::all();
        $streets   = Street::all();
        $incident_types = IncidentType::all();

        return view('incidents.index', compact('incidents', 'barangays', 'streets', 'incident_types'));
    }
      public function create()
    {
         $barangays = Barangay::get();
        $streets   = Street::get();
        $incident_types   = IncidentType::get();
        return view('incidents.create', compact( 'barangays', 'streets','incident_types'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // ✅ if type is "others", insert new type first
            $incident_type_id = $request->type_of_incident;
            if ($incident_type_id === "others") {
                $new_type = new IncidentType;
                $new_type->name = $request->other_incident;
                $new_type->save();
                $incident_type_id = $new_type->id;
            }

            // ✅ Save Incident
            $new_incident = new Incident;
            $new_incident->date = $request->date;
            $new_incident->time = $request->time;
            $new_incident->designation_office = $request->designation_office;
            $new_incident->unit_shift = $request->unit_shift;
            $new_incident->type_of_incident = $incident_type_id;
            $new_incident->description = $request->description;
            $new_incident->enforcer_name = $request->enforcer_name;
            $new_incident->police_notified = $request->police_notified ? 1 : 0;
            $new_incident->province = $request->province;
            $new_incident->city = $request->city;
            $new_incident->barangay_id = $request->barangay_id;
            $new_incident->street_id = $request->street_id;
            $new_incident->street_position = $request->street_position;
            $new_incident->corner_street_id = $request->corner_street_id;
            $new_incident->lat = $request->lat;
            $new_incident->lng = $request->lng;
            $new_incident->remarks = $request->remarks;
            $new_incident->save();

            // ✅ Save Persons
            if ($request->has('persons')) {
                foreach ($request->persons as $person) {
                    if (!empty($person['name'])) {
                        $newPerson = new IncidentPerson;
                        $newPerson->incident_id = $new_incident->id;
                        $newPerson->name = $person['name'];
                        $newPerson->address = $person['address'];
                        $newPerson->contact = $person['contact'];
                        $newPerson->is_main = $person['is_main'];
                        $newPerson->save();
                    }
                }
            }

            // ✅ Save Attachments to /public/uploads/incidents/
            if ($request->hasFile('attachment')) {
                foreach ($request->file('attachment') as $file) {
                    if ($file->isValid()) {
                        $filename = time() . '_' . $file->getClientOriginalName();
                        $file->move(public_path('uploads/incidents'), $filename);

                        $attachment = new IncidentAttachment;
                        $attachment->incident_id = $new_incident->id;
                        $attachment->file_path = 'uploads/incidents/' . $filename;
                        $attachment->file_name = $file->getClientOriginalName();
                        $attachment->save();
                    }
                }
            }

            DB::commit();

            Alert::success('Successfully Saved')->persistent('Dismiss');
            return redirect()->route('incidents.index')->with('success', 'Incident created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            // optional: delete any uploaded files if needed
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save incident: ' . $e->getMessage()]);
        }
    }
}
