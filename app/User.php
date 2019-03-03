<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Phaza\LaravelPostgis\Eloquent\PostgisTrait;
use Phaza\LaravelPostgis\Geometries\Point;

class User extends Authenticatable
{
    use Notifiable;
    use PostgisTrait;

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $postgisFields = [
      'position'
    ];

    protected $postgisTypes = [
      'position' => [
        'geomtype' => 'geometry',
        'srid' => 4326
      ]
    ];

    /**
     * Get the gender for the user .
     */
    public function gender()
    {
        return $this->belongsTo('App\Models\Gender');
    }

    public function hobby()
    {
        return $this->belongsToMany('App\Models\Hobby','users_hobby','users_id','hobby_id');
    }
}
