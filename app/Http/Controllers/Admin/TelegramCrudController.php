<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\MainContract;
use App\Http\Requests\TelegramRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Domain\Contracts\TelegramContract;
use App\Helpers\Telegram\Telegram;
use Illuminate\Support\Facades\Log;

class TelegramCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Telegram::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/telegram');
        CRUD::setEntityNameStrings('Телеграм', 'Телеграм');
        if (backpack_user()->role === TelegramContract::TRANSLATE[TelegramContract::MODERATOR]) {
            $this->crud->addClause('where', TelegramContract::USER_ID, '=',backpack_user()->id);
        }
    }

    public function update(Telegram $telegram)
    {
        $response   =   $this->traitUpdate();
        $telegram->setWebhook($this->crud->getCurrentEntry()->{MainContract::ID},$this->crud->getCurrentEntry()->{MainContract::API_TOKEN});
        return $response;
    }

    public function store(Telegram $telegram)
    {
        $this->crud->addField(['type' => 'hidden', 'name' => MainContract::USER_ID]);
        $this->crud->getRequest()->request->add([MainContract::USER_ID  =>  backpack_user()->id]);
        $store  =   $this->traitStore();
        $telegram->setWebhook($this->crud->getCurrentEntry()->{MainContract::ID},$this->crud->getCurrentEntry()->{MainContract::API_TOKEN});
        return $store;
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(TelegramContract::ID)->label('ID');
        CRUD::column(TelegramContract::API_TOKEN)->label('Телеграм токен');
        CRUD::column(TelegramContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                TelegramContract::ALL   =>  'Все уведомления',
                TelegramContract::REVIEWS   =>  'Отзывы',
                TelegramContract::BOOKINGS  =>  'Бронирование',
                TelegramContract::OFF   =>  'Отключен'
            ]);
    }

    protected function setupListOperation()
    {
        CRUD::column(TelegramContract::ID)->label('ID');
        CRUD::column(TelegramContract::API_TOKEN)->label('Телеграм токен');
        CRUD::column(TelegramContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                TelegramContract::ALL   =>  'Все уведомления',
                TelegramContract::REVIEWS   =>  'Отзывы',
                TelegramContract::BOOKINGS  =>  'Бронирование',
                TelegramContract::OFF   =>  'Отключен'
            ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(TelegramRequest::class);

        CRUD::field(TelegramContract::API_TOKEN)->label('Телеграм токен');
        CRUD::field(TelegramContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                TelegramContract::ALL   =>  'Все уведомления',
                TelegramContract::REVIEWS   =>  'Отзывы',
                TelegramContract::BOOKINGS  =>  'Бронирование',
                TelegramContract::OFF   =>  'Отключен'
            ]);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
