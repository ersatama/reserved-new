<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\TagsOptionRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class TagsOptionCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\TagsOption::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tags-option');
        CRUD::setEntityNameStrings('Опции', 'Опции');
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::TAGS_ID)->type('select')->label('Фильтр')
            ->entity('tags')->model('App\Models\Tags')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::TITLE)->label('Название');
        CRUD::column(MainContract::TITLE_EN)->label('Название на англииском');
        CRUD::column(MainContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(MainContract::STATUS)->label('Статус')->type('select_from_array')->options([
            MainContract::ON    =>  MainContract::TRANSLATE[MainContract::ON],
            MainContract::OFF   =>  MainContract::TRANSLATE[MainContract::OFF],
        ]);

    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(TagsOptionRequest::class);

        CRUD::field(MainContract::TAGS_ID)->type('select')->label('Фильтр')
            ->entity('tags')->model('App\Models\Tags')->attribute(MainContract::TITLE);
        CRUD::field(MainContract::TITLE)->label('Название');
        CRUD::field(MainContract::TITLE_EN)->label('Название на англииском');
        CRUD::field(MainContract::TITLE_KZ)->label('Название на казахском');
        CRUD::field(MainContract::STATUS)->label('Статус')->type('select_from_array')->options([
            MainContract::ON    =>  MainContract::TRANSLATE[MainContract::ON],
            MainContract::OFF   =>  MainContract::TRANSLATE[MainContract::OFF],
        ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
