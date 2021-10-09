<?php

namespace Modules\Deposit\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deposit extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deposit_deposits';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_id', 'approved_by', 'amount', 'approved', 'image'];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'account_id' => 'integer',
        'approved_by' => 'integer',
        'amount' => 'decimal:2',
        'approved' => 'boolean',
        'image' => 'string',
    ];

    protected static function newFactory()
    {
        return \Modules\Deposit\Database\factories\DepositFactory::new();
    }
}
