<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait MovingScopeTrait
{
    public static function bootMovingScopeTrait()
    {
        if (!app()->runningInConsole() && auth()->check()) {
            $isAdmin = auth()->user()->roles->contains(1);

            if (!$isAdmin) {
                static::addGlobalScope('moving_scope', function (Builder $builder) {
                    $field = sprintf('%s.%s', $builder->getQuery()->from, 'user_id');

                    $builder->where($field, auth()->id());
                });
            }
        }
    }
}