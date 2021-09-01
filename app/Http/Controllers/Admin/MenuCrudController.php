<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\OrganizationContract;
use App\Http\Requests\MenuRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Domain\Contracts\MenuContract;
use App\Domain\Repositories\Organization\OrganizationRepositoryEloquent as OrganizationRepository;

class MenuCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    public $organizationsId;
    public function setup()
    {
        CRUD::setModel(\App\Models\Menu::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/menu');
        CRUD::setEntityNameStrings('Меню', 'Меню');
        if (backpack_user()->role === MenuContract::TRANSLATE[MenuContract::MODERATOR]) {
            $this->organizationsId  =   (new OrganizationRepository())->getIdsByUserId(backpack_user()->id);
            $this->crud->addClause('whereIn', MenuContract::ORGANIZATION_ID,$this->organizationsId);
        }
    }

    protected function setupShowOperation()
    {
        CRUD::column(MenuContract::ORGANIZATION_ID)->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(OrganizationContract::TITLE);
        CRUD::column(MenuContract::IMAGE)->type('image')->label('Фото');
        CRUD::column(MenuContract::STATUS)->label('Статус');
    }

    protected function setupListOperation()
    {
        CRUD::column(MenuContract::ORGANIZATION_ID)->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(OrganizationContract::TITLE);
        CRUD::column(MenuContract::IMAGE)->type('image')->label('Фото');
        CRUD::column(MenuContract::STATUS)->label('Статус');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(MenuRequest::class);

        $this->crud->addField([
            'label'                 => 'Заведение',
            'type'                  => 'select2_from_ajax',
            'name'                  => MenuContract::ORGANIZATION_ID,
            'entity'                => 'organization',
            'placeholder'           => '',
            'minimum_input_length'  => '',
            'attribute'             => OrganizationContract::TITLE,
            'data_source'           =>  url('organization')
        ]);

        CRUD::field(MenuContract::IMAGE)->type('image')->label('Фото');
        CRUD::field(MenuContract::STATUS)
            ->type('select_from_array')
            ->label('Статус')->options([
                MenuContract::ON    =>  MenuContract::TRANSLATE[MenuContract::ON],
                MenuContract::OFF   =>  MenuContract::TRANSLATE[MenuContract::OFF],
            ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
