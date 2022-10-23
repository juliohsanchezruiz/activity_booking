<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityReservation extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'activity_id',
        'number_people',
        'total_price',
        'relationship_date',
        'activity_date',
    ];

    protected $casts = [
        'relationship_date' => 'date',
        'activity_date' => 'date',
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
