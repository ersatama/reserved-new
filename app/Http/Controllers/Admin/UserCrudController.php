<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\UserContract;
use App\Http\Requests\UserRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\Sms\SmsService;

class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }

    public function setup()
    {
        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('пользователя', 'Пользователи');
        if (backpack_user()->role === UserContract::TRANSLATE[UserContract::MODERATOR]) {
            $this->crud->denyAccess((array)'update');
            $this->crud->setListView('backpack.user.list');
        }
        $this->crud->setCreateView('backpack.user.create');
    }

    public function store()
    {

        $response = $this->traitStore();
        $sms    =   new SmsService();
        $parameter  =   (array) $this->crud->getRequest()->request;
        foreach ($parameter as &$param) {
            $parameter  =   $param;
            break;
        }
        $sms->sendUser($parameter[UserContract::PHONE],$parameter[UserContract::PASSWORD]);
        return $response;
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(UserContract::CREATED_AT)->label('Дата регистрации');
        if (backpack_user()->role !== UserContract::TRANSLATE[UserContract::MODERATOR]) {
            CRUD::column(UserContract::ROLE)->label('Статус');
            CRUD::column(UserContract::BLOCKED)->label('Заблокирован');
        }
        CRUD::column(UserContract::NAME)->label('Имя');
        CRUD::column(UserContract::PHONE)->label('Телефон номер');
        if (backpack_user()->role !== UserContract::TRANSLATE[UserContract::MODERATOR]) {
            CRUD::column(UserContract::CODE)->label('Код подтверждения');
            CRUD::column(UserContract::PHONE_VERIFIED_AT)->label('Статус телефон номера');
        }
        CRUD::column(UserContract::EMAIL)->label('Эл.почта');
        if (backpack_user()->role !== UserContract::TRANSLATE[UserContract::MODERATOR]) {
            CRUD::column(UserContract::EMAIL_VERIFIED_AT)->label('Статус эл.почты');
        }
    }

    protected function setupListOperation()
    {
        if (backpack_user()->role === UserContract::TRANSLATE[UserContract::MODERATOR]) {
            $this->crud->addClause('where', UserContract::USER_ID,'=',backpack_user()->id);
        }
        CRUD::column(UserContract::ID)->label('ID');
        if (backpack_user()->role !== UserContract::TRANSLATE[UserContract::MODERATOR]) {
            CRUD::column(UserContract::ROLE)->label('Статус');
            CRUD::column(UserContract::BLOCKED)->label('Заблокирован');
        }
        CRUD::column(UserContract::NAME)->label('Имя');
        CRUD::column(UserContract::PHONE)->label('Телефон');
        CRUD::column(UserContract::EMAIL)->label('Эл.почта');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::field(UserContract::USER_ID)->type('hidden')->attributes([
            'required'  =>  'required',
            'default'  =>  backpack_user()->id,
        ])->value(backpack_user()->id);

        if (backpack_user()->role !== UserContract::TRANSLATE[UserContract::MODERATOR]) {
            CRUD::field(UserContract::ROLE)->label('Статус')->type('select_from_array')->options([
                UserContract::USER          =>  UserContract::TRANSLATE[UserContract::USER],
                UserContract::ADMINISTRATOR =>  UserContract::TRANSLATE[UserContract::ADMINISTRATOR],
                UserContract::MODERATOR     =>  UserContract::TRANSLATE[UserContract::MODERATOR],
            ]);

            CRUD::field(UserContract::BLOCKED)->label('Заблокирован')->type('select_from_array')->options([
                UserContract::ON    =>  UserContract::TRANSLATE[UserContract::ON],
                UserContract::OFF   =>  UserContract::TRANSLATE[UserContract::OFF],
            ]);
        }

        CRUD::field(UserContract::NAME)->label('Полное имя')->attributes([
            'required'  =>  'required'
        ]);

    }

    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function list(Request $request)
    {
        if ($request->has('q')) {
            return User::where([
                [UserContract::ID, $request->input('q')],
                [UserContract::ROLE,UserContract::MODERATOR]
            ])->paginate(10);
        }

        return User::where(UserContract::ROLE,UserContract::MODERATOR)->paginate(10);
    }
}
