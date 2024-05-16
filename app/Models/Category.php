<?php

namespace App\Models;

use App\Models\Follow;
use App\Models\Document;
use App\Models\Notificaton;
use App\Models\Notification;
use App\Http\Traits\FollowTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,SoftDeletes,FollowTrait;
//-----------------------------------------------------
    protected $fillable = [
        'name',
    ];
//-----------------------------------------------------
    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }
//-----------------------------------------------------
    public function documents(){
        return $this->hasMany(Document::class);
    }
//-----------------------------------------------------
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
}
