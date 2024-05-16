<?php

namespace App\Http\Traits;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait FollowTrait
{
    public function followers()
    {
        return $this->morphMany(Follow::class, 'followable');
    }


    public function followToggle (){
        $user = Auth::user();
        if ($this->hasFollowedByUser($user)){
            $this->unFollow($user);
            return $message = 'you are Unfollowing ' . $this->name;
        } else {
            $this->follow($user);
            return $message = 'you are following ' . $this->name;
        }
    }

    public function hasFollowedByUser($user)
    {
        return $this->followers()->where('user_id', $user->id)
            ->where('followable_id', $this->id)
            ->where('followable_type', get_class($this))
            ->exists();
    }

    public function follow($user)
    {
        $existingLike = $this->followers()->where([
            'followable_id'     => $this->id,
            'followable_type'   => get_class($this),
            'user_id'           => $user->id,
        ])->first();

        // If the user hasn't liked the blog, create a new like
        if (!$existingLike) {
            $this->followers()->create([
                'followable_id'     => $this->id,
                'followable_type'   => get_class($this),
                'user_id'           => $user->id,
            ]);
        }
    }


    public function unFollow($user)
    {
        $this->followers()->where([
            'user_id' => $user->id,
            'followable_id'     => $this->id,
            'followable_type'   => get_class($this),
        ])->delete();
    }

    public function followersCount()
    {
        return $this->followers->count();
    }
}
