<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
class Street extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id'); 
    }

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'id'); 
    }
}
