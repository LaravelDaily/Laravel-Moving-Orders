<?php

namespace App\Models;

use App\Traits\MovingScopeTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;

class Moving extends Model
{
    use SoftDeletes, HasFactory, MovingScopeTrait;

    public $table = 'movings';

    protected $dates = [
        'moving_date',
        'paid_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'moving_from',
        'moving_to',
        'moving_date',
        'comments',
        'price',
        'paid_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public static function boot()
    {
        parent::boot();
        Moving::observe(new \App\Observers\MovingActionObserver);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getMovingDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setMovingDateAttribute($value)
    {
        $this->attributes['moving_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getPaidAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setPaidAtAttribute($value)
    {
        $this->attributes['paid_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
