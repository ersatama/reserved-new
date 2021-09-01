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

use App\Jobs\OrganizationInfo;

class OrganizationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
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

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        CRUD::column(OrganizationContract::USER_ID)->type('select')->label('Пользователь')
            ->entity('user')->model('App\Models\User')->attribute(UserContract::NAME);
        CRUD::column(OrganizationContract::CITY_ID)->type('select')->label('Город')
            ->entity('city')->model('App\Models\City')->attribute(CityContract::TITLE);
        CRUD::column(OrganizationContract::CATEGORY_ID)->type('select')->label('Категория')
            ->entity('category')->model('App\Models\Category')->attribute(CategoryContract::TITLE);
        CRUD::column(OrganizationContract::TITLE)->label('Название');
        CRUD::column(OrganizationContract::WALLPAPER)->type('image')->label('Обложка');
        CRUD::column(OrganizationContract::IMAGE)->type('image')->label('Лого');
        CRUD::column(OrganizationContract::RATING)->label('Реитинг');
        CRUD::column(OrganizationContract::ADDRESS)->label('Адрес');
        CRUD::column(OrganizationContract::EMAIL)->label('Эл.почта');
        CRUD::column(OrganizationContract::PHONE)->label('Телефон номер');
        CRUD::column(OrganizationContract::WEBSITE)->label('Веб-сайт');
        CRUD::column(OrganizationContract::STATUS)->label('Статус');
        CRUD::column(OrganizationContract::START_MONDAY)->label('Понедельник');
        CRUD::column(OrganizationContract::TUESDAY)->label('Вторник');
        CRUD::column(OrganizationContract::WEDNESDAY)->label('Среда');
        CRUD::column(OrganizationContract::THURSDAY)->label('Четверг');
        CRUD::column(OrganizationContract::FRIDAY)->label('Пятница');
        CRUD::column(OrganizationContract::SATURDAY)->label('Суббота');
        CRUD::column(OrganizationContract::SUNDAY)->label('Воскресенье');
    }

    protected function setupListOperation()
    {
        if (backpack_user()->role === OrganizationContract::TRANSLATE[OrganizationContract::MODERATOR]) {
            $this->crud->addClause('where', OrganizationContract::USER_ID, '=',backpack_user()->id);
        }
        CRUD::column(OrganizationContract::USER_ID)->type('select')->label('Пользователь')
            ->entity('user')->model('App\Models\User')->attribute(UserContract::NAME);
        CRUD::column(OrganizationContract::CATEGORY_ID)->type('select')->label('Категория')
            ->entity('category')->model('App\Models\Category')->attribute(CategoryContract::TITLE);
        CRUD::column(OrganizationContract::TITLE)->label('Название');
        CRUD::column(OrganizationContract::RATING)->label('Рейтинг');
        CRUD::column(OrganizationContract::ADDRESS)->label('Адрес');
        CRUD::column(OrganizationContract::STATUS)->label('Статус');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(OrganizationRequest::class);
        if (backpack_user()->role === OrganizationContract::TRANSLATE[OrganizationContract::MODERATOR]) {

            $this->crud->addField([
                'id'    =>  BookingContract::TIMEZONE,
                'name'  =>  BookingContract::TIMEZONE,
                'type'  =>  'hidden',
            ]);

            $this->crud->addField([
                'name'      => OrganizationContract::CITY_ID,
                'label'     => 'Город',
                'type'      => 'select',
                'entity'    => 'city',
                'model'     => "App\Models\City",
                'attribute' => OrganizationContract::TITLE,
            ]);

            CRUD::field(OrganizationContract::TITLE)->label('Название')->attributes([
                'required'  =>  'required'
            ]);

            CRUD::field(OrganizationContract::WALLPAPER)->label('Обложка')->type('image')->attributes([
                'accept'    =>  'image/png, image/jpeg, image/jpg',
            ]);

            CRUD::field(OrganizationContract::IMAGE)->label('Логотип')->type('image')->attributes([
                'accept'    =>  'image/png, image/jpeg, image/jpg'
            ]);

            CRUD::field(OrganizationContract::DESCRIPTION)->type('textarea')->label('Описание');
            CRUD::field(OrganizationContract::DESCRIPTION_KZ)->type('textarea')->label('Описание на казахском');
            CRUD::field(OrganizationContract::DESCRIPTION_EN)->type('textarea')->label('Описание на англииском');
            CRUD::field(OrganizationContract::ADDRESS)->label('Адресс');
            CRUD::field(OrganizationContract::ADDRESS_KZ)->label('Адресс на казахском');
            CRUD::field(OrganizationContract::ADDRESS_EN)->label('Адресс на англииском');

            CRUD::field(OrganizationContract::EMAIL)->label('Эл.почта');
            CRUD::field(OrganizationContract::PHONE)->label('Телефон номер');
            CRUD::field(OrganizationContract::WEBSITE)->label('Веб-сайт');

            CRUD::field(OrganizationContract::PRICE)->label('Цена');

            CRUD::field(OrganizationContract::TABLES)->label('Количество столов');

            CRUD::field(OrganizationContract::START_MONDAY)->type('time')->label('Понедельник начало');
            CRUD::field(OrganizationContract::END_MONDAY)->type('time')->label('Понедельник конец');

            CRUD::field(OrganizationContract::START_TUESDAY)->type('time')->label('Вторник начало');
            CRUD::field(OrganizationContract::END_TUESDAY)->type('time')->label('Вторник конец');

            CRUD::field(OrganizationContract::START_WEDNESDAY)->type('time')->label('Среда начало');
            CRUD::field(OrganizationContract::END_WEDNESDAY)->type('time')->label('Среда конец');

            CRUD::field(OrganizationContract::START_THURSDAY)->type('time')->label('Четверг начало');
            CRUD::field(OrganizationContract::END_THURSDAY)->type('time')->label('Четверг конец');

            CRUD::field(OrganizationContract::START_FRIDAY)->type('time')->label('Пятница начало');
            CRUD::field(OrganizationContract::END_FRIDAY)->type('time')->label('Пятница конец');

            CRUD::field(OrganizationContract::START_SATURDAY)->type('time')->label('Суббота начало');
            CRUD::field(OrganizationContract::END_SATURDAY)->type('time')->label('Суббота конец');

            CRUD::field(OrganizationContract::START_SUNDAY)->type('time')->label('Воскресенье начало');
            CRUD::field(OrganizationContract::END_SUNDAY)->type('time')->label('Воскресенье конец');

        } else {

            CRUD::field(OrganizationContract::TITLE)->label('Название')->attributes([
                'required'  =>  'required'
            ]);

            $this->crud->addField([
                'id'    =>  BookingContract::TIMEZONE,
                'name'  =>  BookingContract::TIMEZONE,
                'type'  =>  'hidden',
            ]);

            $this->crud->addField([
                'label'                 => 'ID пользователя',
                'type'                  => 'text',
                'name'                  => OrganizationContract::USER_ID,
//                'entity'                => 'user',
//                'placeholder'           => '',
//                'minimum_input_length'  => '',
//                'attribute'             => UserContract::ID,
//                'data_source'           =>  url('users')
            ]);

            $this->crud->addField([
                'name'      => OrganizationContract::CITY_ID,
                'label'     => 'Город',
                'type'      => 'select',
                'entity'    => 'city',
                'model'     => "App\Models\City",
                'attribute' => OrganizationContract::TITLE,
            ]);

            $this->crud->addField([
                'name'      => OrganizationContract::CATEGORY_ID,
                'label'     => 'Категория',
                'type'      => 'select',
                'entity'    => 'category',
                'model'     => "App\Models\Category",
                'attribute' => CategoryContract::TITLE,
            ]);

            CRUD::field(OrganizationContract::STATUS)->type('select_from_array')
                ->label('Статус')->options([
                    OrganizationContract::ENABLED    =>  OrganizationContract::TRANSLATE[OrganizationContract::ENABLED],
                    OrganizationContract::DISABLED   =>  OrganizationContract::TRANSLATE[OrganizationContract::DISABLED],
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
            if (backpack_user()->role === OrganizationContract::TRANSLATE[OrganizationContract::MODERATOR]) {
                $results = Organization::where([
                    [OrganizationContract::TITLE, 'LIKE', '%'.$search_term.'%'],
                    [OrganizationContract::USER_ID,backpack_user()->id]
                ])->paginate(10);
            } else {
                $results = Organization::where(OrganizationContract::TITLE, 'LIKE', '%'.$search_term.'%')->paginate(10);
            }
        } else {
            if (backpack_user()->role === OrganizationContract::TRANSLATE[OrganizationContract::MODERATOR]) {
                $results = Organization::where(OrganizationContract::USER_ID,backpack_user()->id)->paginate(10);
            } else {
                $results = Organization::paginate(10);
            }
        }
        return $results;
    }
}
