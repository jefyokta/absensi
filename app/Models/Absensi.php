<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Absensi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function division()
    {
        return $this->belongsTo(Division::class, 'divisions_id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function users(): HasMany
    {

        return $this->hasMany(User::class, 'id');
    }
}
