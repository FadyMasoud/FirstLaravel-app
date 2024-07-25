<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Showroom extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'showrooms';

    protected $fillable = [
        'name', 'address', 'contact_number', 'email'
    ];
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
