<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    use ApiResponseTrait;
    public function showUnreadNotification(){
        // $user_id = Auth::id();
        // $user = User::where('id', $user_id)->first();
        // $unreadNotifications = $user->notifications()->where('is_read', false)->get();
        $unreadNotifications = Notification::all();
        return $this->customeResponse(NotificationResource::collection($unreadNotifications),'Done',200);
    }


    public function markNotificationAsRead(Notification $notification){
        $user_id = Auth::id();
        $user = User::where('id', $user_id)->first();
        $user->notifications()->updateExistingPivot($notification,['is_read'=>true]);
        return $this->customeResponse(new NotificationResource($notification),'Done',200);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
