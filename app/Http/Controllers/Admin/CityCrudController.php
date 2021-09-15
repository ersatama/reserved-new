<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\CityContract;
use App\Domain\Contracts\CountryContract;
use App\Domain\Contracts\MainContract;
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
        CRUD::column(MainContract::COUNTRY_ID)->type('select')->label('Страна')
            ->entity('country')->model('App\Models\Country')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::TIMEZONE)->label('Часовой пояс');
        CRUD::column(MainContract::TITLE)->label('Название');
        CRUD::column(MainContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(MainContract::TITLE_EN)->label('Название на англииском');
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::COUNTRY_ID)->type('select')->label('Страна')
            ->entity('country')->model('App\Models\Country')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::TIMEZONE)->label('Часовой пояс');
        CRUD::column(MainContract::TITLE)->label('Название');
        CRUD::column(MainContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(MainContract::TITLE_EN)->label('Название на англииском');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CityRequest::class);

        $this->crud->addFields([
            [
                'name'  => MainContract::COUNTRY_ID,
                'label' => 'Страна',
                'type'  => 'select',
                'entity'    => 'country',
                'model'     => "App\Models\Country",
                'attribute' => MainContract::TITLE,
            ]
        ]);
        CRUD::field(MainContract::TIMEZONE)->label('Часовой пояс')->type('text')->attributes([
            'required'  =>  'required'
        ]);
        CRUD::field(MainContract::TITLE)->label('Название на русском (обязательное поле)')->type('text')->attributes([
            'required'  =>  'required'
        ]);
        CRUD::field(MainContract::TITLE_KZ)->label('Название на казахском')->type('text');
        CRUD::field(MainContract::TITLE_EN)->label('Название на англииском')->type('text');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
