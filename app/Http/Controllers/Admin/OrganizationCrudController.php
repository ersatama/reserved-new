<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\CategoryContract;
use App\Domain\Contracts\CityContract;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\OrganizationContract;
use App\Domain\Contracts\UserContract;
use App\Http\Requests\OrganizationRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Organization;
use Illuminate\Http\Request;

use App\Services\Api\ApiService;
use App\Services\Organization\OrganizationService;
use App\Services\City\CityService;
use App\Services\Iiko\IikoService;

use App\Jobs\OrganizationInfo;
use App\Helpers\Iiko\Iiko;

class OrganizationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Organization::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/organization');
        CRUD::setEntityNameStrings('организацию', 'Организации');
        if (backpack_user() && backpack_user()->role === MainContract::TRANSLATE[MainContract::MODERATOR]) {
            $this->crud->denyAccess((array)'create');
            $this->crud->setListView('backpack.organization.list');
        }
    }

    public function store(Iiko $iiko, IikoService $iikoService, CityService $cityService)
    {
        $this->crud->addField(['type' => 'hidden', 'name' => MainContract::TIMEZONE]);
        $data   =   (array) $this->crud->getRequest()->request;
        foreach ($data as &$param) {
            $data  =   $param;
            break;
        }
        $city   =   $cityService->getById($data[MainContract::CITY_ID]);

        $this->crud->getRequest()->request->add([MainContract::TIMEZONE =>  $city->{MainContract::TIMEZONE}]);

        return $this->traitStore();

    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(MainContract::USER_ID)->type('select')->label('Пользователь')
            ->entity('user')->model('App\Models\User')->attribute(MainContract::NAME);
        CRUD::column(MainContract::CITY_ID)->type('select')->label('Город')
            ->entity('city')->model('App\Models\City')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::CATEGORY_ID)->type('select')->label('Категория')
            ->entity('category')->model('App\Models\Category')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::TIMEZONE)->label('Часовой пояс');
        CRUD::column(MainContract::TITLE)->label('Название');
        CRUD::column(MainContract::WALLPAPER)->type('image')->label('Обложка');
        CRUD::column(MainContract::IMAGE)->type('image')->label('Лого');
        CRUD::column(MainContract::RATING)->label('Реитинг');
        CRUD::column(MainContract::ADDRESS)->label('Адрес');
        CRUD::column(MainContract::EMAIL)->label('Эл.почта');
        CRUD::column(MainContract::PHONE)->label('Телефон номер');
        CRUD::column(MainContract::WEBSITE)->label('Веб-сайт');
        CRUD::column(MainContract::STATUS)->label('Статус');
        CRUD::column(MainContract::START_MONDAY)->label('Понедельник');
        CRUD::column(MainContract::TUESDAY)->label('Вторник');
        CRUD::column(MainContract::WEDNESDAY)->label('Среда');
        CRUD::column(MainContract::THURSDAY)->label('Четверг');
        CRUD::column(MainContract::FRIDAY)->label('Пятница');
        CRUD::column(MainContract::SATURDAY)->label('Суббота');
        CRUD::column(MainContract::SUNDAY)->label('Воскресенье');
    }

    protected function setupListOperation()
    {
        if (backpack_user()->role === MainContract::TRANSLATE[MainContract::MODERATOR]) {
            $this->crud->addClause('where', MainContract::USER_ID, '=',backpack_user()->id);
        }
        CRUD::column(MainContract::USER_ID)->type('select')->label('Пользователь')
            ->entity('user')->model('App\Models\User')->attribute(MainContract::NAME);
        CRUD::column(MainContract::CATEGORY_ID)->type('select')->label('Категория')
            ->entity('category')->model('App\Models\Category')->attribute(MainContract::TITLE);
        CRUD::column(MainContract::TITLE)->label('Название');
        CRUD::column(MainContract::RATING)->label('Рейтинг');
        CRUD::column(MainContract::ADDRESS)->label('Адрес');
        CRUD::column(MainContract::STATUS)->label('Статус');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrganizationRequest::class);
        if (backpack_user()->role === MainContract::TRANSLATE[MainContract::MODERATOR]) {

            $this->crud->addField([
                'id'    =>  MainContract::TIMEZONE,
                'name'  =>  MainContract::TIMEZONE,
                'type'  =>  'hidden',
            ]);

            $this->crud->addField([
                'name'      => MainContract::CITY_ID,
                'label'     => 'Город',
                'type'      => 'select',
                'entity'    => 'city',
                'model'     => "App\Models\City",
                'attribute' => MainContract::TITLE,
            ]);

            CRUD::field(MainContract::TITLE)->label('Название')->attributes([
                'required'  =>  'required'
            ]);

            CRUD::field(MainContract::WALLPAPER)->label('Обложка')->type('image')->attributes([
                'accept'    =>  'image/png, image/jpeg, image/jpg',
            ]);

            CRUD::field(MainContract::IMAGE)->label('Логотип')->type('image')->attributes([
                'accept'    =>  'image/png, image/jpeg, image/jpg'
            ]);

            CRUD::field(MainContract::DESCRIPTION)->type('textarea')->label('Описание');
            CRUD::field(MainContract::DESCRIPTION_KZ)->type('textarea')->label('Описание на казахском');
            CRUD::field(MainContract::DESCRIPTION_EN)->type('textarea')->label('Описание на англииском');
            CRUD::field(MainContract::ADDRESS)->label('Адресс');
            CRUD::field(MainContract::ADDRESS_KZ)->label('Адресс на казахском');
            CRUD::field(MainContract::ADDRESS_EN)->label('Адресс на англииском');

            CRUD::field(MainContract::EMAIL)->label('Эл.почта');
            CRUD::field(MainContract::PHONE)->label('Телефон номер');
            CRUD::field(MainContract::WEBSITE)->label('Веб-сайт');

            CRUD::field(MainContract::PRICE)->label('Цена');

            CRUD::field(MainContract::TABLES)->label('Количество столов');

            CRUD::field(MainContract::START_MONDAY)->type('time')->label('Понедельник начало');
            CRUD::field(MainContract::END_MONDAY)->type('time')->label('Понедельник конец');

            CRUD::field(MainContract::START_TUESDAY)->type('time')->label('Вторник начало');
            CRUD::field(MainContract::END_TUESDAY)->type('time')->label('Вторник конец');

            CRUD::field(MainContract::START_WEDNESDAY)->type('time')->label('Среда начало');
            CRUD::field(MainContract::END_WEDNESDAY)->type('time')->label('Среда конец');

            CRUD::field(MainContract::START_THURSDAY)->type('time')->label('Четверг начало');
            CRUD::field(MainContract::END_THURSDAY)->type('time')->label('Четверг конец');

            CRUD::field(MainContract::START_FRIDAY)->type('time')->label('Пятница начало');
            CRUD::field(MainContract::END_FRIDAY)->type('time')->label('Пятница конец');

            CRUD::field(MainContract::START_SATURDAY)->type('time')->label('Суббота начало');
            CRUD::field(MainContract::END_SATURDAY)->type('time')->label('Суббота конец');

            CRUD::field(MainContract::START_SUNDAY)->type('time')->label('Воскресенье начало');
            CRUD::field(MainContract::END_SUNDAY)->type('time')->label('Воскресенье конец');

        } else {

            CRUD::field(MainContract::TITLE)->label('Название')->attributes([
                'required'  =>  'required'
            ]);

            $this->crud->addField([
                'label'                 => 'ID пользователя',
                'type'                  => 'text',
                'name'                  => MainContract::USER_ID,
//                'entity'                => 'user',
//                'placeholder'           => '',
//                'minimum_input_length'  => '',
//                'attribute'             => UserContract::ID,
//                'data_source'           =>  url('users')
            ]);

            $this->crud->addField([
                'name'      => MainContract::CITY_ID,
                'label'     => 'Город',
                'type'      => 'select',
                'entity'    => 'city',
                'model'     => "App\Models\City",
                'attribute' => MainContract::TITLE,
            ]);

            $this->crud->addField([
                'name'      => MainContract::CATEGORY_ID,
                'label'     => 'Категория',
                'type'      => 'select',
                'entity'    => 'category',
                'model'     => "App\Models\Category",
                'attribute' => MainContract::TITLE,
            ]);

            CRUD::field(MainContract::STATUS)->type('select_from_array')
                ->label('Статус')->options([
                    MainContract::ENABLED    =>  MainContract::TRANSLATE[MainContract::ENABLED],
                    MainContract::DISABLED   =>  MainContract::TRANSLATE[MainContract::DISABLED],
                ]);
        }

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function list(Request $request) {
        if ($request->has('q')) {
            $search_term = $request->input('q');
            if (backpack_user()->role === MainContract::TRANSLATE[MainContract::MODERATOR]) {
                $results = Organization::where([
                    [MainContract::TITLE, 'LIKE', '%'.$search_term.'%'],
                    [MainContract::USER_ID,backpack_user()->id]
                ])->paginate(10);
            } else {
                $results = Organization::where(MainContract::TITLE, 'LIKE', '%'.$search_term.'%')->paginate(10);
            }
        } else {
            if (backpack_user()->role === MainContract::TRANSLATE[MainContract::MODERATOR]) {
                $results = Organization::where(MainContract::USER_ID,backpack_user()->id)->paginate(10);
            } else {
                $results = Organization::paginate(10);
            }
        }
        return $results;
    }
}
