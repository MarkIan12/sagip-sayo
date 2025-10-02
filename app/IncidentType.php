<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class IncidentType extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public function incidents()
    {
        return $this->hasMany(Incident::class,'type_of_incident','id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id'); 
    }
}
