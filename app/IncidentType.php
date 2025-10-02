<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class IncidentType extends Model implements Auditable
{
    //
    use \OwenIt\Auditing\Auditable;
    public function incidents()
    {
        return $this->hasMany(Incident::class,'type_of_incident','id');
    }
}
