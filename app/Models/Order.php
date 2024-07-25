<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'Orders';

    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'product_id',
        'order_date',
        'Qauntity',
        'total_price',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
