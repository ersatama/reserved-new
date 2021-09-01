<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Contracts\OrganizationContract;
use App\Domain\Contracts\UserContract;
use App\Http\Requests\ReviewRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Review;
use App\Domain\Contracts\ReviewContract;
use App\Domain\Repositories\Organization\OrganizationRepositoryEloquent as OrganizationRepository;

use App\Services\Review\ReviewService;

use App\Events\ReviewCreated;

class ReviewCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
//    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    public $organizationsId;
    protected $reviewService;
    public function __construct(ReviewService $reviewService)
    {
        parent::__construct();
        $this->reviewService    =   $reviewService;
    }

    public function update()
    {
        $response = $this->traitUpdate();
        $parameter  =   (array) $this->crud->getRequest()->request;
        foreach ($parameter as &$param) {
            $parameter  =   $param;
            break;
        }
        $review =   $this->reviewService->getById($parameter[ReviewContract::ID]);
        event(new ReviewCreated($review));
        return $response;
    }
    public function setup()
    {
        CRUD::setModel(Review::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/review');
        CRUD::setEntityNameStrings('отзыв', 'Отзывы');
        if (backpack_user() && backpack_user()->role === ReviewContract::TRANSLATE[ReviewContract::MODERATOR]) {
            $this->crud->denyAccess((array)'create');
            $this->crud->denyAccess((array)'update');
            $this->organizationsId  =   (new OrganizationRepository())->getIdsByUserId(backpack_user()->id);
            $this->crud->addClause('whereIn', ReviewContract::ORGANIZATION_ID,$this->organizationsId);
            $this->crud->addClause('whereIn', ReviewContract::STATUS,[
                ReviewContract::ENABLED,
                ReviewContract::DISABLED,
                ReviewContract::CANCELED,
            ]);
        }
    }

    protected function setupShowOperation()
    {
        CRUD::column(ReviewContract::ORGANIZATION_ID)->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(OrganizationContract::TITLE);
        CRUD::column(ReviewContract::USER_ID)->type('select')->label('Пользователь')
            ->entity('user')->model('App\Models\User')->attribute(OrganizationContract::NAME);
        CRUD::column(ReviewContract::RATING)->label('Рейтинг');
        CRUD::column(ReviewContract::COMMENT)->label('Комментарии');
        CRUD::column(ReviewContract::STATUS)->label('Статус');
    }

    protected function setupListOperation()
    {
        CRUD::column(ReviewContract::ORGANIZATION_ID)->type('select')->label('Организация')
            ->entity('organization')->model('App\Models\Organization')->attribute(OrganizationContract::TITLE);
        CRUD::column(ReviewContract::USER_ID)->type('select')->label('Пользователь')
            ->entity('user')->model('App\Models\User')->attribute(OrganizationContract::NAME);
        CRUD::column(ReviewContract::RATING)->label('Рейтинг');
        CRUD::column(ReviewContract::COMMENT)->label('Комментарии');
        CRUD::column(ReviewContract::STATUS)->label('Статус');
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ReviewRequest::class);

        $this->crud->addField([
            'label'         => 'Имя',
            'type'          => 'select2_from_ajax',
            'name'          => ReviewContract::USER_ID,
            'entity'        => 'user',
            'placeholder'   => '',
            'minimum_input_length'  => '',
            'attribute'     => UserContract::NAME,
            'data_source'   =>  url('api/users')
        ]);

        $this->crud->addField([
            'label'         => 'Организация',
            'type'          => 'select2_from_ajax',
            'name'          => ReviewContract::ORGANIZATION_ID,
            'entity'        => 'organization',
            'placeholder'   => '',
            'minimum_input_length'  => '',
            'attribute'     => OrganizationContract::TITLE,
            'data_source'   =>  url('api/organization')
        ]);

        CRUD::field(ReviewContract::RATING)->label('Реитинг');
        CRUD::field(ReviewContract::COMMENT)->label('Комментарии');
        CRUD::field(ReviewContract::STATUS)->type('select_from_array')
            ->label('Статус')->options([
                ReviewContract::ENABLED    =>  ReviewContract::TRANSLATE[ReviewContract::ENABLED],
                ReviewContract::CANCELED   =>  ReviewContract::TRANSLATE[ReviewContract::CANCELED],
                ReviewContract::CHECKING   =>  ReviewContract::TRANSLATE[ReviewContract::CHECKING],
            ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
