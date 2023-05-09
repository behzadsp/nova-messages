<?php

declare(strict_types=1);

namespace BehzadSp\NovaMessages;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use BehzadSp\NovaMessages\Models\Message;

trait Messagble
{
    /**
     * @return MorphMany<Message>
     */
    public function messages(): MorphMany
    {
        return $this->morphMany(Message::class, 'messagble');
    }
}
