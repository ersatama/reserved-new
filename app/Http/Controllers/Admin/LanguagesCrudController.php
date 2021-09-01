<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\LanguagesContract;
use App\Http\Requests\LanguagesRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

class LanguagesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Languages::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/languages');
        CRUD::setEntityNameStrings('languages', 'languages');
    }

    protected function setupShowOperation()
    {
        CRUD::column(LanguagesContract::TITLE)->lable('Язык');
    }

    protected function setupListOperation()
    {
        CRUD::column(LanguagesContract::TITLE)->lable('Язык');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(LanguagesRequest::class);

        CRUD::field(LanguagesContract::TITLE)->lable('Язык');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
