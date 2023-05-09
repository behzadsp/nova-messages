<?php

declare(strict_types=1);

namespace BehzadSp\NovaMessages;

use BehzadSp\NovaMessages\Nova\Message;
use Laravel\Nova\Fields\MorphMany;
use Laravel\Nova\Panel;

class MessagesPanel extends Panel
{
    /**
     * Create a new panel instance.
     */
    public function __construct()
    {
        parent::__construct('Messages', $this->prepareFields($this->fields()));
    }

    /**
     * Fields for the message panel.
     */
    protected function fields(): array
    {
        return [
            MorphMany::make(
                config('nova-messages.messages-panel.name'),
                'messages',
                Message::class
            ),
        ];
    }
}
