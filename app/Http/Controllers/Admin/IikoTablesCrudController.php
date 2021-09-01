<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\IikoTablesRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\IikoTables;
use App\Domain\Contracts\IikoTablesContract;

class IikoTablesCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(IikoTables::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/iikotables');
        CRUD::setEntityNameStrings('iiko комнаты', 'iiko комнаты');
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(IikoTablesContract::KEY)->label('Ключ');
        CRUD::column(IikoTablesContract::NAME)->label('Название');
        CRUD::column(IikoTablesContract::STATUS)->label('Статус');
    }

    protected function setupListOperation()
    {
        CRUD::column(IikoTablesContract::KEY)->label('Ключ');
        CRUD::column(IikoTablesContract::NAME)->label('Название');
        CRUD::column(IikoTablesContract::STATUS)->label('Статус');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(IikoTablesRequest::class);
        CRUD::field(IikoTablesContract::KEY)->label('Ключ');
        CRUD::field(IikoTablesContract::NAME)->label('Название');
        CRUD::field(IikoTablesContract::STATUS)->label('Статус');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
