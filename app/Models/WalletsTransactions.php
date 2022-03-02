<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletsTransactions extends Model
{
    use HasFactory;

	protected $table = 'wallets_transactions';
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo('App\Model\User','user_id','id');
    }

	public function wallets_transactions()
    {
        return $this->belongsTo('App\Model\WalletsTransactions','trans_id','id');
    }

}
