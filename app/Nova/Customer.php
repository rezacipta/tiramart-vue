<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Http\Requests\NovaRequest;

class Customer extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Customer::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'code', 'name', 'email', 'whatsapp_number'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')
                ->sortable()
                ->hideFromIndex(),

            Text::make(__('Code'), 'code')
                ->sortable()
                ->hideWhenCreating()
                ->hideWhenUpdating(),

            Text::make(__('Name'), 'name')
                ->sortable()
                ->rules('required'),

            Text::make(__('Email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:255')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),

            Number::make(__('Phone'), 'phone')
                ->sortable()
                ->rules('required'),

            Number::make(__('Whatsapp'), 'whatsapp_number')
                ->sortable()
                ->rules('required'),

            Select::make(__('Type'), 'member_type')
                ->sortable()
                ->rules('required')
                ->displayUsingLabels()
                ->options([
                    '1' => 'Customer',
                    '2' => 'Reseller',
                    '3' => 'EPC',
                    '4' => 'EPD',
                ]),

            Boolean::make(__('Active'), 'status')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->status ?? true]),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [
            new Metrics\NewCustomers,
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [
            new Filters\CustomerActive,
            new Filters\CustomerType,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
