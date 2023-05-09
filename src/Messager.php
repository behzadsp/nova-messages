<?php

declare(strict_types=1);

namespace BehzadSp\NovaMessages;

use Laravel\Nova\ResourceTool;

class Messager extends ResourceTool
{
    /**
     * Get the displayable name of the resource tool.
     */
    public function name(): string
    {
        return 'Messager';
    }

    /**
     * Get the component name for the resource tool.
     */
    public function component(): string
    {
        return 'messager';
    }
}
