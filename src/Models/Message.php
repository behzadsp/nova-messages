<?php

declare(strict_types=1);

namespace BehzadSp\NovaMessages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'nova_messages';

    /**
     * The "booting" method of the model.
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(
            function ($message): void {
                if (auth()->check()) {
                    $message->messager_id = auth()->id();
                }
            }
        );
    }

    /**
     * @return MorphTo
     */
    public function messagble(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function messager(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'messager_id');
    }
}
