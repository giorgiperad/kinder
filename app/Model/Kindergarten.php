<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use App\Model\API\Kindergartener;
use DB;

class Kindergarten extends Model
{
    protected $fillable = [
      'name',
      'municipality_id'
    ];

    // public static function boot(){

    //   parent::boot();

    //    self::creating(function($model){
    //      print_r($model); exit;
    //   });

    //    self::updating(function($model){
    //        print_r($model); exit;
    //     });
    // }

    public function getCreatedAtAttribute ($date) {
        return Carbon::parse($date)->format('m/d/y');
    }

    public function municipality()
    {
       return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }

    public function groupAgeRanges()
    {
        return $this->belongsToMany(GroupAgeRange::class, 'kindergarten_group_age_range', 'kindergarten_id', 'group_age_range')->withPivot('space_length')->withPivot('space_filled')->withPivot('space_free');
    }

    public function currentAge($range) {
        $model = $this;
        $groupAgeRange = $this->groupAgeRanges()
            ->wherePivot('kindergarten_id', $model->id)->wherePivot('group_age_range', $range)->firstOrNew([]);
        $groupAgeRange->setRelation('byId', $this->KindergartenersByGroupId($range));
        return $groupAgeRange;
    }

    public function Kindergarteners()
    {
        return $this->hasMany(Kindergartener::class)->active();
    }

    public function KindergartenersList()
    {
        return $this->Kindergarteners()
          ->join('group_age_ranges', 'kindergarteners.group_id', '=', 'group_age_ranges.id')
          ->select('kindergarten_id', 'group_id', DB::raw("count(*) as total"), 'group_age_ranges.range')
          ->groupBy('group_id', 'kindergarten_id');
    }

    public function KindergartenersByGroupId($range)
    {
        return $this->KindergartenersList->where('group_id', $range)->first();
    }
}

// $this->groupAgeRanges()->first(function ($value, $key) use ($model, $range) {
//   return $value->pivot->kindergarten_id == $model->id && $value->pivot->group_age_range == $range;
// })


