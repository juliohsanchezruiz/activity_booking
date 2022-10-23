<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'start_at',
        'end_at',
        'price_person',
        'popularity',
    ];

    protected $casts = [
        'start_at' => 'date',
        'end_at' => 'date',
    ];

    public function activities()
    {
        return $this->hasMany(ActivitiesActivity::class, 'activity_parent_id');
    }
}
