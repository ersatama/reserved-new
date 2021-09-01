<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\CountryContract;
use App\Http\Requests\CountryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Country;
/**
 * Class CountryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CountryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(Country::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/country');
        CRUD::setEntityNameStrings('страну', 'Страны');
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(CountryContract::TITLE)->label('Название');
        CRUD::column(CountryContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(CountryContract::TITLE_EN)->label('Название на англииском');
    }

    protected function setupListOperation()
    {
        CRUD::column(CountryContract::TITLE)->label('Название');
        CRUD::column(CountryContract::TITLE_KZ)->label('Название на казахском');
        CRUD::column(CountryContract::TITLE_EN)->label('Название на англииском');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(CountryRequest::class);
        CRUD::field(CountryContract::TITLE)->label('Название *');
        CRUD::field(CountryContract::TITLE_KZ)->label('Название на казахском');
        CRUD::field(CountryContract::TITLE_EN)->label('Название на англииском');
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
