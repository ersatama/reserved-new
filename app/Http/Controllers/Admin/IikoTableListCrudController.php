<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\OrganizationContract;
use App\Domain\Contracts\OrganizationTableListContract;
use App\Http\Requests\IikoTableListRequest;
use App\Models\Organization;
use App\Models\OrganizationTableList;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Models\IikoTableList;
use App\Domain\Contracts\IikoTableListContract;

use App\Services\Organization\OrganizationService;
use App\Services\OrganizationTableList\OrganizationTableListService;

class IikoTableListCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    protected $organizationTableListsIds    =   [];

    protected $organizationService;
    protected $organizationTableListService;

    public function __construct(OrganizationService $organizationService, OrganizationTableListService $organizationTableListService)
    {
        parent::__construct();
        $this->organizationService  =   $organizationService;
        $this->organizationTableListService =   $organizationTableListService;
    }

    public function setup()
    {
        CRUD::setModel(\App\Models\IikoTableList::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/iikotablelist');
        CRUD::setEntityNameStrings('iiko стол', 'iiko столы');
        if (backpack_user()->role === IikoTableListContract::TRANSLATE[IikoTableListContract::MODERATOR]) {
            $organizations  =   $this->organizationService->getByUserId(backpack_user()->id);
            foreach ($organizations as &$organization) {
                $tables =   $this->organizationTableListService->getByOrganizationId($organization->{OrganizationContract::ID});
                foreach ($tables as &$table) {
                    $this->organizationTableListsIds[]  =   $table->{OrganizationTableListContract::ID};
                }
            }
        }
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(IikoTableListContract::ORGANIZATION_TABLE_LIST_ID)->type('select')->label('Стол')
            ->entity('organizationTableList')->model('App\Models\OrganizationTableList')->attribute(OrganizationTableListContract::TITLE);
        CRUD::column(IikoTableListContract::KEY)->label('Ключ');
        CRUD::column(IikoTableListContract::TITLE)->label('Название');
        CRUD::column(IikoTableListContract::LIMIT)->label('Лимит');
        CRUD::column(IikoTableListContract::STATUS)->label('Статус');
    }

    protected function setupListOperation()
    {
        CRUD::column(IikoTableListContract::ORGANIZATION_TABLE_LIST_ID)->type('select')->label('Стол')
            ->entity('organizationTableList')->model('App\Models\OrganizationTableList')->attribute(OrganizationTableListContract::TITLE);
        CRUD::column(IikoTableListContract::TITLE)->label('Название');
        CRUD::column(IikoTableListContract::LIMIT)->label('Лимит');
        CRUD::column(IikoTableListContract::STATUS)->label('Статус');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(IikoTableListRequest::class);
        if (backpack_user()->role === IikoTableListContract::TRANSLATE[IikoTableListContract::MODERATOR]) {
            $this->crud->addClause('whereIn', OrganizationTableListContract::ID,$this->organizationTableListsIds);
        }
        CRUD::field(IikoTableListContract::ORGANIZATION_TABLE_LIST_ID)->type('select')->label('Стол')
            ->entity('organizationTableList')->model('App\Models\OrganizationTableList')->attribute(OrganizationTableListContract::TITLE);
        CRUD::field(IikoTableListContract::TITLE)->label('Название');
        CRUD::field(IikoTableListContract::LIMIT)->label('Лимит');
        CRUD::field(IikoTableListContract::STATUS)->label('Статус');

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
