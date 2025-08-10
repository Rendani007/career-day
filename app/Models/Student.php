<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class Student extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'attended'      => 'boolean',
        'checked_in_at' => 'datetime',   // <= important
    ];

    protected $fillable = [
        'name',
        'surname',
        'grade',
        'studentnum',
        'email',
        'phone',
        'id_number',
        'school_id',
        'day_industry_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = $model->id ?? (string) Str::uuid();
        });
    }

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function dayIndustry()
    {
        return $this->belongsTo(DayIndustry::class);
    }
}
