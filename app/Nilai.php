<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Nilai extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
       'kode_nilai', '_siswa', '_dudi', 'periode', 'nilais', 'nt1', 'nt2', 'nt3', 'nt4', 'nt5', 'nt6', 'nt7', 'nt8', 't1', 't2', 't3', 't4', 't5', 't6', 't7', 't8', 't9', 't10' 
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        // 'api_token'
    ];
}
