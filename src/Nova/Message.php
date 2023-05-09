<?php

namespace BehzadSp\NovaMessages\Nova;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use BehzadSp\NovaMessages\Models\Message as MessageModel;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\MorphTo;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Resource;

class Message extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = MessageModel::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'message',
    ];

    /**
     * Get the fields displayed by the resource.
     */
    public function fields(NovaRequest $request): array
    {
        return [
            Textarea::make('message')
                ->alwaysShow()
                ->hideFromIndex(),

            MorphTo::make('Messagble')->onlyOnIndex(),

            Text::make('message')
                ->displayUsing(function ($message) {
                    return Str::limit($message, config('nova-messages.limit'));
                })
                ->onlyOnIndex(),

            BelongsTo::make('Messager', 'messager', config('nova-messages.messager.nova-resource'))
                ->exceptOnForms(),

            DateTime::make('Created', 'created_at')
                ->exceptOnForms()
                ->sortable(),
        ];
    }

    /**
     * Get the cards available for the request.
     */
    public function cards(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     */
    public function filters(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     */
    public function lenses(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     */
    public function actions(NovaRequest $request): array
    {
        return [];
    }

    /**
     * Determine if this resource is available for navigation.
     */
    public static function availableForNavigation(Request $request): bool
    {
        return config('nova-messages.available-for-navigation');
    }
}
