<?php

namespace App;

use App\Mail\UserRegistered;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'birthday',
        'phone',
        'identity_card',
        'city',
        'password',
        'privacy_terms',
        'whatsapp_consent',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'save_salesforce'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function codes(){
        return $this->hasMany(Code::class);
    }

    public function getFullNameAttribute(){
        return $this->name.' '.$this->last_name;
    }

    public function getPointsWeekAttribute()
    {
        $points = 0;
        $week = Week::selection(request()->week)->first();
        $items = $this->codes()->where('status',1)->get();

        foreach( $items->where('semana_id',($week->id??null) ) as $i){
            $points += $i->points;
        }

        return $points;
    }
    public function getPointsGlobalAttribute()
    {
        $items = $this->codes()->where('status',1)->get();
        return $items->sum('points');
    }

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value);
    }
    public function setPrivacyTermsAttribute($value){
        $this->attributes['privacy_terms'] = $value ? 1 : 0;
    }
    public function setWhatsappConsentAttribute($value){
        $this->attributes['whatsapp_consent'] = $value ? 1 : 0;
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new UserRegistered($this));
    }
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($this,$token));
    }
}
