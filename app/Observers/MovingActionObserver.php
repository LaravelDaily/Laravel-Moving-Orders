<?php

namespace App\Observers;

use App\Models\Moving;
use App\Notifications\DataChangeEmailNotification;
use App\Notifications\MovingPaidNotification;
use App\Notifications\PriceChangeNotification;
use Illuminate\Support\Facades\Notification;

class MovingActionObserver
{
    public function created(Moving $model)
    {
        $data  = ['action' => 'created', 'model_name' => 'Moving', 'id' => $model->id];
        $users = \App\Models\User::whereHas('roles', function ($q) {
            return $q->where('title', 'Admin');
        })->get();
        Notification::send($users, new DataChangeEmailNotification($data));
    }

    public function updating(Moving $model)
    {
        $model->load('user');

        if ($model->user && $model->isDirty('price') && $model->getOriginal('price') == null) {
            $model->user->notify(new PriceChangeNotification($model));
        }
    }
}
