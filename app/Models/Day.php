<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Day extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['name', 'event_id', 'event_date'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function industries()
    {
        return $this->belongsToMany(Industry::class, 'day_industries');
    }

   
}

