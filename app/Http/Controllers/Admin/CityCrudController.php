<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\CityContract;
use App\Domain\Contracts\CountryContract;
use App\Http\Requests\CityRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\City;

class CityCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(City::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/city');
        CRUD::setEntityNameStrings('город', 'Города');
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(CityContract::COUNTRY_ID)->type('select')->label('Страна')
            ->entity('country')->model('App\Models\Country')->attribute(CountryContract::TITLE);
        CRUD::column(CityContract::TITLE)->label('Название');
        CRUD::column(CityContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(CityContract::TITLE_EN)->label('Название на англииском');
    }

    protected function setupListOperation()
    {
        CRUD::column(CityContract::COUNTRY_ID)->type('select')->label('Страна')
            ->entity('country')->model('App\Models\Country')->attribute(CountryContract::TITLE);
        CRUD::column(CityContract::TITLE)->label('Название');
        CRUD::column(CityContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(CityContract::TITLE_EN)->label('Название на англииском');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CityRequest::class);

        $this->crud->addFields([
            [
                'name'  => CityContract::COUNTRY_ID,
                'label' => 'Страна',
                'type'  => 'select',
                'entity'    => 'country',
                'model'     => "App\Models\Country",
                'attribute' => CountryContract::TITLE,
            ]
        ]);

        CRUD::field(CityContract::TITLE)->label('Название на русском (обязательное поле)')->type('text')->attributes([
            'required'  =>  'required'
        ]);
        CRUD::field(CityContract::TITLE_KZ)->label('Название на казахском')->type('text');
        CRUD::field(CityContract::TITLE_EN)->label('Название на англииском')->type('text');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
