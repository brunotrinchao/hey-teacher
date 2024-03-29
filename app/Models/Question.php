<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};
use Illuminate\Database\Eloquent\{Model, Prunable, SoftDeletes};

class Question extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Prunable;

    public mixed $draft;

    protected $casts = [
        'draft' => 'boolean',
    ];

    /**
     * @return HasMany<Vote>
     */
    public function votes(): HasMany
    {
        return  $this->hasMany(Vote::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function likes(): Attribute
    {
        return new Attribute(get: fn () => $this->votes()->sum('like'));
    }

    protected function unlikes(): Attribute
    {
        return new Attribute(get: fn () => $this->votes()->sum('unlike'));
    }

    public function prunable(): Builder
    {
        return static::where('deleted_at', '<=', now()->subMonths());
    }
}
