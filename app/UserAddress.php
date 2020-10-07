<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserAddress extends Model
{
    protected $table='useraddress';

    protected $fillable = [
        'address','user_id','isprimary'
    ];

    public function user()
    {
    	return $this->belongsTo('\App\User');
    }
}
