<?php

namespace App\Model\API;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Model\Municipality;
use App\Model\Kindergarten;
use App\Model\GroupAgeRange;
use App\Model\ActiveStatus;
use App\Model\KindergartnerPriority;

class Kindergartener extends Model
{
    //

    protected $fillable = [
        'municipality_id', 
        'kindergarten_id', 
        'group_id',
        'active_status_id',
        'kids_personal_number', 
        'kids_first_name',
        'kids_last_name',
        'mother_personal_number',
        'mother_first_name',
        'mother_last_name',
        'father_personal_number',
        'father_first_name',
        'father_last_name',
        'mobile_number',
        'email'
    ];

    public function getCreatedAtAttribute ($date) {
        return Carbon::parse($date)->format('m/d/y');
    }


    public function scopeActive ($query)
    {
       return $query->whereNotIn('active_status_id', [3,4]);
    }


    public function municipality()
    {
       return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }

    public function kindergarten()
    {
       return $this->belongsTo(Kindergarten::class, 'kindergarten_id', 'id');
    }

    public function groupRange()
    {
       return $this->belongsTo(GroupAgeRange::class, 'group_id', 'id');
    }

    public function activeStatus()
    {
       return $this->belongsTo(ActiveStatus::class, 'active_status_id', 'id');
    }

    public function priority()
    {
       return $this
         ->hasOne(KindergartnerPriority::class, 'kindergartner_id')
         ->join('priorities', 'kindergartner_priorities.priority_id', '=', 'priorities.id');
    }


}






