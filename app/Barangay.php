<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model implements Auditable
{ 
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $table = "barangays";
    protected $fillable = [
        'name', 'created_by'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id'); 
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

}
