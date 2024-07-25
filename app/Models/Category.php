<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'Categories';
    protected $fillable = ['name', 'pd_name', 'images', 'description', 'speed', 'type', 'price'];
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = false;


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function getRouteKeyName()
    // {
    //     return 'pd_name';
    // }

    // public function getImagesAttribute($value)
    // {
    //     return json_decode($value);
    // }
}
