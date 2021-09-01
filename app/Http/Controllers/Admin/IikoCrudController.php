<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\OrganizationContract;
use App\Http\Requests\IikoRequest;
use App\Jobs\OrganizationInfo;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\Iiko;
use App\Domain\Contracts\IikoContract;

use App\Services\Organization\OrganizationService;
use App\Services\Iiko\IikoService;

use App\Helpers\Iiko\Iiko as IikoHelper;

class IikoCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    protected $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        parent::__construct();
        $this->organizationService  =   $organizationService;
    }

    public function setup()
    {
        CRUD::setModel(Iiko::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/iiko');
        CRUD::setEntityNameStrings('iiko', 'iikos');
    }

    public function store(IikoHelper $iiko, IikoService $iikoService)
    {
        $this->crud->addField(['type' => 'hidden', 'name' => OrganizationContract::IIKO_ORGANIZATION_ID]);

        $data   =   (array) $this->crud->getRequest()->request;
        foreach ($data as &$param) {
            $data  =   $param;
            break;
        }

        $iiko   =   $iiko->getOrganizations($data[IikoContract::API_ID],$data[IikoContract::API_SECRET]);

        if (sizeof($iiko) > 0) {
            $this->crud->getRequest()->request->add([IikoContract::IIKO_ORGANIZATION_ID    =>  $iiko[IikoContract::ID]]);
        }

        $store  =   $this->traitStore();
        OrganizationInfo::dispatch($iikoService->getById($this->crud->getCurrentEntry()->{IikoContract::ID}));
        return $store;

    }

    protected function setupShowOperation()
    {
        CRUD::column(IikoContract::ORGANIZATION_ID)->type('select')->label('Заведение')
            ->entity('organization')->model('App\Models\Organization')->attribute(OrganizationContract::TITLE);
        CRUD::column(IikoContract::IIKO_ORGANIZATION_ID)->label('Iiko ID заведения');
        CRUD::column(IikoContract::IIKO_ID)->label('Iiko ID');
        CRUD::column(IikoContract::API_KEY)->label('Iiko api ключ');
        CRUD::column(IikoContract::API_ID)->label('Iiko api ID');
        CRUD::column(IikoContract::API_SECRET)->label('Iiko api пароль');
        CRUD::column(IikoContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                IikoContract::ENABLED    =>  IikoContract::TRANSLATE[IikoContract::ENABLED],
                IikoContract::DISABLED   =>  IikoContract::TRANSLATE[IikoContract::DISABLED],
            ]);
    }

    protected function setupListOperation()
    {
        if (backpack_user()->role === IikoContract::TRANSLATE[IikoContract::MODERATOR]) {
            $this->crud->addClause('whereIn', IikoContract::ORGANIZATION_ID, $this->organizationService->getIdsByUserId(backpack_user()->id));
        }
        CRUD::column(IikoContract::ORGANIZATION_ID)->type('select')->label('Заведение')
            ->entity('organization')->model('App\Models\Organization')->attribute(OrganizationContract::TITLE);
        CRUD::column(IikoContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                IikoContract::ENABLED    =>  IikoContract::TRANSLATE[IikoContract::ENABLED],
                IikoContract::DISABLED   =>  IikoContract::TRANSLATE[IikoContract::DISABLED],
            ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(IikoRequest::class);
        if (backpack_user() && backpack_user()->role === IikoContract::TRANSLATE[IikoContract::MODERATOR]) {

            $this->crud->addField([
                'label'                 => 'Заведение',
                'type'                  => 'select2_from_ajax',
                'name'                  => IikoContract::ORGANIZATION_ID,
                'entity'                => 'organization',
                'placeholder'           => 'Выберите организацию',
                'minimum_input_length'  => '',
                'attribute'             => OrganizationContract::TITLE,
                'data_source'           =>  url('api/organization/user/'.backpack_user()->id)
            ]);

        } else {

            $this->crud->addField([
                'name'      => IikoContract::ORGANIZATION_ID,
                'label'     => 'Заведение',
                'type'      => 'select',
                'entity'    => 'organization',
                'placeholder'   => 'Выберите организацию',
                'model'     => "App\Models\Organization",
                'attribute' => OrganizationContract::TITLE,
                'attributes'    =>  [
                    'required'
                ]
            ]);

        }

        CRUD::field(IikoContract::IIKO_ID)->label('Iiko ID')->type('number');
        CRUD::field(IikoContract::API_KEY)->label('Iiko api ключ');
        CRUD::field(IikoContract::API_ID)->label('Iiko api ID');
        CRUD::field(IikoContract::API_SECRET)->label('Iiko api пароль');
        CRUD::field(IikoContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                IikoContract::ENABLED    =>  IikoContract::TRANSLATE[IikoContract::ENABLED],
                IikoContract::DISABLED   =>  IikoContract::TRANSLATE[IikoContract::DISABLED],
            ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
