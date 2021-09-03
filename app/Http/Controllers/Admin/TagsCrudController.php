<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\TagsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;


class TagsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Tags::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tags');
        CRUD::setEntityNameStrings('Фильтр', 'Фильтры');
    }

    protected function setupListOperation()
    {
        CRUD::column(MainContract::ID)->label('ID');
        CRUD::column(MainContract::TITLE)->label('Название');
        CRUD::column(MainContract::TITLE_EN)->label('Название на англииском');
        CRUD::column(MainContract::TITLE_KZ)->label('Название на казахском');
    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(TagsRequest::class);

        CRUD::field(MainContract::TITLE)->label('Название');
        CRUD::field(MainContract::TITLE_EN)->label('Название на англииском');
        CRUD::field(MainContract::TITLE_KZ)->label('Название на казахском');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
