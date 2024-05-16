<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }

    public function users(){
        return $this->belongsToMany(User::class,'user_notification')->withPivot('is_read');
    }
}
