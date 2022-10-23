<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivitiesActivity extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'activity_parent_id',
        'activity_id',
    ];

    public function activity()
    {
        return $this->hasOne(Activity::class, 'id', 'activity_id');

    }
}
