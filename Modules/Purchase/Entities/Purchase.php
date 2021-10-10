<?php

namespace Modules\Purchase\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Purchase extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'purchase_purchases';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['account_id', 'description', 'amount'];

     /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'account_id' => 'integer',
        'description' => 'string',
        'amount' => 'decimal:2',
    ];

    protected static function newFactory()
    {
        return \Modules\Purchase\Database\factories\PurchaseFactory::new();
    }
}
