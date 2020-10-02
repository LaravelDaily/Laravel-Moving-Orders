<?php

namespace App\Observers;

use App\Models\Moving;
use App\Notifications\DataChangeEmailNotification;
use Illuminate\Support\Facades\Notification;

class MovingActionObserver
{
    public function created(Moving $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Moving'];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }
}
