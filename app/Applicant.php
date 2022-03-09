<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;
use App\ReferralSource;

class Applicant extends Model
{
    protected $fillable = [        
        'number',
        'first_name',
        'last_name',
        'email',
        'about',
        'note',
        'applicant_status_id',
        'country_id',
        'referral_source_id',
        'attachment',
    ];

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }
    
    public function status()
    {
        return $this->belongsTo('App\ApplicantStatus', 'applicant_status_id');
    }

    public function referral_source()
    {        
        return $this->belongsTo('App\ReferralSource');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    static function applyAsCandidateDropdown()
    {
        $data['countries'] = Country::orderBy('id', 'ASC')->pluck('name', 'id')->toArray();
        $data['referral_sources'] = ReferralSource::orderBy('display_order', 'ASC')->pluck('name', 'id')->toArray();

        return $data;
    }

    static function adminSearchDropdown()
    {
        $data['statuses'] =  ['' => 'All'] + ApplicantStatus::orderBy('id', 'ASC')->pluck('name', 'id')->toArray();
        $data['referral_sources'] = ['' => 'All'] + ReferralSource::orderBy('display_order', 'ASC')->pluck('name', 'id')->toArray();

        return $data;
    }
}
