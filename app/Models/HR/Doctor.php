<?php

namespace App\Models\HR;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use Notifiable;
    protected $table = 'doctors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function user()
    {
        return $this->hasOne('App\User', 'user_id', 'user_id');
    }
    public function designation()
    {
        return $this->hasOne('App\Models\Settings\Designation', 'designation_id', 'designation_id');
    }
    public function educationalQualification()
    {
        return $this->hasOne('App\Models\Settings\EducationalQualification', 'educational_qualification_id', 'educational_qualification_id');
    }
    public function medicalDegree()
    {
        return $this->hasOne('App\Models\Settings\MedicalDegree', 'medical_degree_id', 'medical_degree_id');
    }
}
