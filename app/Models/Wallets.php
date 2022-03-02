<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    use HasFactory;

	protected $table = 'wallets';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Model\User','user_id','id');
    }

}
