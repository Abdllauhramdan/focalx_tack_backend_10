<?php

namespace App\Models;

use App\Models\User;
use App\Models\Notificaton;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Comment extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'comment',
        'user_id',
    ];

    public function commentable(){
        return $this->morphTo();
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }
    protected static function boot() {
        parent::boot();

        static::creating(function($document){
            $document->user_id = Auth::user()->id;
        });
    }

    public function user() {
        $this->belongsTo(User::class);
    }

}
