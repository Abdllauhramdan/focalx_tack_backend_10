<?php

namespace App\Models;

use App\Models\Tag;
use App\Models\User;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Download;
use App\Models\Notificaton;
use App\Models\Notification;
use Ayham\Like\Trait\Likeable;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\DownloadFileTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Document extends Model
{
    use HasFactory,SoftDeletes,DownloadFileTrait,Likeable;

    protected $fillable = [
        'title',
        'description',
        'file',
        'category_id',
        'user_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class,'document_tag');
    }

    public function downloads()
    {
        return $this->morphMany(Download::class, 'downloadable');
    }

    public function comments() {
        return $this->morphMany(Comment::class,'commentable');
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

}
