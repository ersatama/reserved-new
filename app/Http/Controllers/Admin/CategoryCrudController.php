<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\CategoryContract;
use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Category;

class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('категорию', 'Категория');
    }

    protected function setupShowOperation()
    {
        CRUD::column(CategoryContract::SLUG)->label('Путь');
        CRUD::column(CategoryContract::TITLE)->label('Название');
        CRUD::column(CategoryContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(CategoryContract::TITLE_EN)->label('Название на англииском');
        CRUD::column(CategoryContract::DESCRIPTION)->label('Описание');
        CRUD::column(CategoryContract::DESCRIPTION_KZ)->label('Описание на казахском');
        CRUD::column(CategoryContract::DESCRIPTION_EN)->label('Описание на англииском');
    }

    protected function setupListOperation()
    {
        CRUD::column(CategoryContract::SLUG)->label('Путь');
        CRUD::column(CategoryContract::TITLE)->label('Название');
        CRUD::column(CategoryContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(CategoryContract::TITLE_EN)->label('Название на англииском');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);
        CRUD::field(CategoryContract::SLUG)->label('Путь (restaurants,cafe) и тд.');
        CRUD::field(CategoryContract::TITLE)->label('Название *');
        CRUD::field(CategoryContract::TITLE_KZ)->label('Название на казахском');
        CRUD::field(CategoryContract::TITLE_EN)->label('Название на англииском');
        CRUD::field(CategoryContract::DESCRIPTION)->type('textarea')->label('Описание');
        CRUD::field(CategoryContract::DESCRIPTION_KZ)->type('textarea')->label('Описание на казахском');
        CRUD::field(CategoryContract::DESCRIPTION_EN)->type('textarea')->label('Описание на англииском');
        $this->crud->addField([
            'name'      => CategoryContract::IMAGE,
            'label'     => 'Логотип',
            'type'      => 'image',
            'accept'    => 'image/png, image/jpeg, image/jpg',
            'crop'      => true,
            'aspect_ratio'  =>  1,
        ]);
        $this->crud->addField([
            'name'      => CategoryContract::WALLPAPER,
            'label'     => 'Обложка',
            'type'      => 'image',
            'accept'    => 'image/png, image/jpeg, image/jpg',
            'crop'      => true,
            'aspect_ratio'  =>  2,
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
