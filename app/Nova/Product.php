<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\HasOneThrough;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Http\Requests\NovaRequest;

class Product extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Product::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'code';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'code',
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
                ->rules('required')
                ->hideFromIndex(),

            Text::make(__('Code'), 'code')
                ->sortable()
                ->rules('required'),

            Select::make(__('Type'), 'type')
                ->rules('required')
                ->displayUsingLabels()
                ->options([
                    'M' => 'M',
                    'S' => 'S',
                ]),

            Number::make(__('Price'), 'amount')
                ->rules('required')
                ->onlyOnForms(),

            Number::make(__('Price'), 'amount', function() {
                    return 'Rp ' . number_format($this->amount, 0, ',', '.');
                })
                ->sortable()
                ->exceptOnForms(),

            Number::make(__('Weight'), 'weight')
                ->rules('required')
                ->onlyOnForms(),

            Number::make(__('Weight'), 'weight', function() {
                    return number_format($this->weight, 0, ',', '.') . ' gr';
                })
                ->sortable()
                ->exceptOnForms(),

            BelongsTo::make(__('Title'), 'productlang', \App\Nova\ProductLang::class)
                ->rules('required', 'exists:base_id,id')
                ->showCreateRelationButton()
                ->searchable(),

            Image::make('Thumbnail'),

            Boolean::make(__('Active'), 'is_active')
                ->sortable()
                ->trueValue('1')
                ->falseValue('0')
                ->withMeta(['value' => $this->is_active ?? true]),
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
        return [];
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
            new Filters\ProductActive,
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
