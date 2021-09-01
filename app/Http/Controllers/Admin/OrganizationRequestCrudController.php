<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\OrganizationRequestRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Domain\Contracts\MainContract;

class OrganizationRequestCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\OrganizationRequest::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/organizationrequest');
        CRUD::setEntityNameStrings('Запрос', 'Запросы');
    }

    protected function setupShowOperation()
    {
        CRUD::column(MainContract::NAME)->label('Имя');
        CRUD::column(MainContract::PHONE)->label('Телефон Номер');
        CRUD::column(MainContract::ORGANIZATION_NAME)->label('Заведение');
        CRUD::column(MainContract::CATEGORY_ID)
            ->type('select')
            ->label('Категория')
            ->entity('category')
            ->model('App\Models\Category')
            ->attribute(MainContract::TITLE);
        CRUD::column(MainContract::CITY_ID)
            ->type('select')
            ->label('Город')
            ->entity('city')
            ->model('App\Models\City')
            ->attribute(MainContract::TITLE);
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                MainContract::ON    =>  MainContract::TRANSLATE[MainContract::ON],
                MainContract::OFF   =>  MainContract::TRANSLATE[MainContract::OFF],
                MainContract::REJECTED  =>  MainContract::TRANSLATE[MainContract::REJECTED],
            ]);
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::NAME)->label('Имя');
        CRUD::column(MainContract::PHONE)->label('Телефон Номер');
        CRUD::column(MainContract::ORGANIZATION_NAME)->label('Заведение');
        CRUD::column(MainContract::CATEGORY_ID)
            ->type('select')
            ->label('Категория')
            ->entity('category')
            ->model('App\Models\Category')
            ->attribute(MainContract::TITLE);
        CRUD::column(MainContract::CITY_ID)
            ->type('select')
            ->label('Город')
            ->entity('city')
            ->model('App\Models\City')
            ->attribute(MainContract::TITLE);
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                MainContract::ON    =>  MainContract::TRANSLATE[MainContract::ON],
                MainContract::OFF   =>  MainContract::TRANSLATE[MainContract::OFF],
                MainContract::REJECTED  =>  MainContract::TRANSLATE[MainContract::REJECTED],
            ]);

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrganizationRequestRequest::class);
        CRUD::field(MainContract::ORGANIZATION_NAME)->label('Заведение');
        CRUD::field(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                MainContract::ON    =>  MainContract::TRANSLATE[MainContract::ON],
                MainContract::OFF   =>  MainContract::TRANSLATE[MainContract::OFF],
                MainContract::REJECTED  =>  MainContract::TRANSLATE[MainContract::REJECTED],
            ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
