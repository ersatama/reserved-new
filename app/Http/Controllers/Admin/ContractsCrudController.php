<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContractsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Domain\Contracts\ContractContract;
use App\Models\Contracts;

class ContractsCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Contracts::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contracts');
        CRUD::setEntityNameStrings('Договор оферты', 'Договор оферты');
    }

    protected function setupListOperation()
    {
        CRUD::column(ContractContract::ID)->label('ID');
        CRUD::column(ContractContract::JSON)->label('Контент');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ContractsRequest::class);
        $this->crud->addField([
            'name'  =>  ContractContract::JSON,
            'label' =>  'Контент',
            'type'  =>  'ckeditor',
            'extra_plugins' =>  ['widget'],
            'options'   =>  [
                'autoGrow_minHeight'   => 200,
                'autoGrow_bottomSpace' => 50,
                'removePlugins'        => 'resize,maximize',
            ]
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
