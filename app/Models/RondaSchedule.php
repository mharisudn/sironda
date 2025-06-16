<?php

namespace App\Models;

use App\Enums\ShiftType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RondaSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ronda_termin_id',
        'polling_code_id',
        'shift_type',
        'is_leader',
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
            'ronda_termin_id' => 'integer',
            'polling_code_id' => 'integer',
            'shift_type' => ShiftType::class,
            'is_leader' => 'boolean',
        ];
    }

    public function rondaTermin(): BelongsTo
    {
        return $this->belongsTo(RondaTermin::class);
    }

    public function pollingCode(): BelongsTo
    {
        return $this->belongsTo(PollingCode::class);
    }
}
