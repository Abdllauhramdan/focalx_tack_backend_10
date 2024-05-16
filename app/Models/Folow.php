<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Folow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'followable_id',
        'followable_type',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    protected static function boot() {
        parent::boot();
        
        static::creating(function($document){
            $document->user_id = Auth::user()->id;
        });
    }

    public function followable(){
        return $this->morphTO();
    }

}
