<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\OrganizationContract;
use App\Http\Requests\OrganizationImageRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\OrganizationImage;
use App\Domain\Contracts\OrganizationImageContract;
use App\Domain\Repositories\Organization\OrganizationRepositoryEloquent as OrganizationRepository;

class OrganizationImageCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ReorderOperation;
    public $organizationsId;

    protected function setupReorderOperation()
    {
        $this->crud->set('reorder.label', OrganizationImageContract::TITLE);
        $this->crud->set('reorder.max_level', 1);
    }

    public function setup()
    {
        CRUD::setModel(OrganizationImage::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/organizationimage');
        CRUD::setEntityNameStrings('Фото', 'Фотографии');
        if (backpack_user()->role === OrganizationImageContract::TRANSLATE[OrganizationImageContract::MODERATOR]) {
            $this->organizationsId  =   (new OrganizationRepository())->getIdsByUserId(backpack_user()->id);
            $this->crud->addClause('whereIn', OrganizationImageContract::ORGANIZATION_ID,$this->organizationsId);
        }
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(OrganizationImageContract::ORGANIZATION_ID)->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(OrganizationContract::TITLE);
        CRUD::column(OrganizationImageContract::IMAGE)->type('image')->label('Фото');
        CRUD::column(OrganizationImageContract::STATUS)->label('Статус');
        CRUD::column(OrganizationImageContract::CREATED_AT)->label('Добавлен');
    }

    protected function setupListOperation()
    {
        CRUD::column(OrganizationImageContract::ORGANIZATION_ID)->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(OrganizationContract::TITLE);
        CRUD::column(OrganizationImageContract::IMAGE)->type('image')->label('Фото');
        CRUD::column(OrganizationContract::STATUS)->label('Статус');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrganizationImageRequest::class);

        $this->crud->addField([
            'label'                 => 'Заведение',
            'type'                  => 'select2_from_ajax',
            'name'                  => OrganizationImageContract::ORGANIZATION_ID,
            'entity'                => 'organization',
            'placeholder'           => '',
            'minimum_input_length'  => '',
            'attribute'             => OrganizationContract::TITLE,
            'data_source'           =>  url('organization')
        ]);

        CRUD::field(OrganizationImageContract::IMAGE)
            ->type('image')->label('Фото');

        CRUD::field(OrganizationImageContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                OrganizationImageContract::ENABLED    =>  OrganizationImageContract::TRANSLATE[OrganizationImageContract::ENABLED],
                OrganizationImageContract::DISABLED   =>  OrganizationImageContract::TRANSLATE[OrganizationImageContract::DISABLED],
            ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
