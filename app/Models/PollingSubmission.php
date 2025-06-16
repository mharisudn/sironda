<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollingSubmission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'polling_code_id',
        'ronda_termin_id',
        'sort',
        'submitted_at',
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
            'polling_code_id' => 'integer',
            'ronda_termin_id' => 'integer',
            'sort' => 'integer',
            'submitted_at' => 'timestamp',
        ];
    }

    public function pollingCode(): BelongsTo
    {
        return $this->belongsTo(PollingCode::class);
    }

    public function rondaTermin(): BelongsTo
    {
        return $this->belongsTo(RondaTermin::class);
    }
}
