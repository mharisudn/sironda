<?php

namespace App\Models;

use App\Enums\ShiftType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PollingCode extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'shift_type',
        'is_leader',
        'is_locked',
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
            'shift_type' => ShiftType::class,
            'is_leader' => 'boolean',
            'is_locked' => 'boolean',
        ];
    }

    public function pollingSubmissions(): HasMany
    {
        return $this->hasMany(PollingSubmission::class);
    }
}
