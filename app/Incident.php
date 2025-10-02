<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Incident extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;
     public function attachments()
    {
        return $this->hasMany(IncidentAttachment::class);
    }

    // Persons involved
    public function persons()
    {
        return $this->hasMany(IncidentPerson::class);
    }

    // Barangay
    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'id');
    }

    // Incident type
    public function incident_types()
    {
        return $this->belongsTo(IncidentType::class, 'type_of_incident', 'id');
    }
     public function type()
    {
        return $this->belongsTo(IncidentType::class, 'type_of_incident', 'id');
    }

    // Street
    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id', 'id');
    }

    // Corner street (optional)
    public function cornerStreet()
    {
        return $this->belongsTo(Street::class, 'corner_street_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'created_by','id');
    }
}
