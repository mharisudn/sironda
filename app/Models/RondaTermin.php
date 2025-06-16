<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RondaTermin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ronda_periode_id',
        'name',
        'start_date',
        'end_date',
        'max_petugas',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'ronda_periode_id' => 'integer',
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    public function rondaPeriode(): BelongsTo
    {
        return $this->belongsTo(RondaPeriode::class);
    }

    public function pollingSubmissions(): HasMany
    {
        return $this->hasMany(PollingSubmission::class);
    }

    public function rondaSchedules(): HasMany
    {
        return $this->hasMany(RondaSchedule::class);
    }
}
