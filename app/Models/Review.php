<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'Reviews';
    protected $guarded = ['id'];
    protected $fillable = [
        'product_id', 'user_id', 'rating', 'comment', 'softdeleted'
    ];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
