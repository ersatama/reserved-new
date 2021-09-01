<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PrivacyRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Domain\Contracts\PrivacyContract;
use App\Models\Privacy;

class PrivacyCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Privacy::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/privacy');
        CRUD::setEntityNameStrings('Политика конфиденциальности', 'Политика конфиденциальности');
    }

    protected function setupListOperation()
    {
        CRUD::column(PrivacyContract::ID)->label('ID');
        CRUD::column(PrivacyContract::JSON)->label('Контент');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(PrivacyRequest::class);
        $this->crud->addField([
            'name'  =>  PrivacyContract::JSON,
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
