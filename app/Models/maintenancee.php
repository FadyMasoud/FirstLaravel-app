<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class maintenancee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'Maintenancee';
    protected $fillable = ['name', 'email', 'phone', 'car', 'subject', 'maintenance_center', 'appointment','user_id'];
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $timestamps = false;

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    


}
