<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\NewsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class NewsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\News::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/news');
        CRUD::setEntityNameStrings('Новость', 'Новости');
    }

    protected function setupShowOperation()
    {
        CRUD::column(MainContract::ORGANIZATION_ID)->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::TITLE)->label('Заголовок');
        CRUD::column(MainContract::DESCRIPTION)->label('Описание');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                MainContract::ON        =>  MainContract::TRANSLATE[MainContract::ON],
                MainContract::CHECKING  =>  MainContract::TRANSLATE[MainContract::CHECKING],
                MainContract::OFF       =>  MainContract::TRANSLATE[MainContract::OFF],
            ]);;
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::ORGANIZATION_ID)->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::TITLE)->label('Заголовок');
        CRUD::column(MainContract::DESCRIPTION)->label('Описание');
        CRUD::column(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                MainContract::ON        =>  MainContract::TRANSLATE[MainContract::ON],
                MainContract::CHECKING  =>  MainContract::TRANSLATE[MainContract::CHECKING],
                MainContract::OFF       =>  MainContract::TRANSLATE[MainContract::OFF],
            ]);;
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(NewsRequest::class);

        CRUD::field('organization_id')->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(MainContract::TITLE);
        CRUD::field(MainContract::TITLE)->label('Заголовок');
        CRUD::field(MainContract::DESCRIPTION)->label('Описание');
        CRUD::field(MainContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                MainContract::ON        =>  MainContract::TRANSLATE[MainContract::ON],
                MainContract::CHECKING  =>  MainContract::TRANSLATE[MainContract::CHECKING],
                MainContract::OFF       =>  MainContract::TRANSLATE[MainContract::OFF],
            ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
