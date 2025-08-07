<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class DayIndustry extends Model
{
    use HasFactory;

    protected $table = 'day_industries';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['day_id', 'industry_id'];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function day()
    {
        return $this->belongsTo(Day::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}
