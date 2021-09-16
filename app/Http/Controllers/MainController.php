<?php

namespace App\Http\Controllers;

use App\Domain\Contracts\MainContract;
use Illuminate\Http\Request;
use App\Services\Organization\OrganizationService;
use App\Services\OrganizationTable\OrganizationTableService;
use App\Services\OrganizationTableList\OrganizationTableListService;
use App\Services\Booking\BookingService;
use App\Services\User\UserService;
use App\Services\Category\CategoryService;
use App\Services\WebTraffic\WebTrafficService;
use App\Services\TagsOption\TagsOptionService;
use App\Jobs\WebTraffic;

class MainController extends Controller
{

    protected $organizationService;
    protected $organizationTableService;
    protected $organizationTableListService;
    protected $bookingService;
    protected $userService;
    protected $categoryService;
    protected $webTrafficService;
    protected $tagsOptionService;

    public function __construct(OrganizationService $organizationService, OrganizationTableService $organizationTableService, OrganizationTableListService $organizationTableListService, BookingService $bookingService, UserService $userService, CategoryService $categoryService, WebTrafficService $webTrafficService, TagsOptionService $tagsOptionService) {
        $this->organizationService  =   $organizationService;
        $this->organizationTableService =   $organizationTableService;
        $this->organizationTableListService =   $organizationTableListService;
        $this->bookingService   =   $bookingService;
        $this->userService  =   $userService;
        $this->categoryService  =   $categoryService;
        $this->webTrafficService    =   $webTrafficService;
        $this->tagsOptionService    =   $tagsOptionService;
    }

    public function dashboard() {
        if (!backpack_auth()->user()) {
            return redirect('/admin/login');
        }
        if (backpack_user()->role === MainContract::TRANSLATE[MainContract::MODERATOR]) {
            $organization   =   $this->organizationService->getByUserId(backpack_auth()->user()->id);
            return view('backpack.dashboard.dashboard',['organization' => $organization]);
        } else {
            return view('backpack.dashboard.administrator');
        }
    }

    public function entity()
    {
        if (!backpack_auth()->user()) {
            return redirect('/admin/login');
        }
        $organization   =   $this->organizationService->getByUserId(backpack_auth()->user()->id);
        return view('backpack.entity.entity',['id'=>$organization->id]);
    }

    public function menus()
    {
        if (!backpack_auth()->user()) {
            return redirect('/admin/login');
        }
        $organization   =   $this->organizationService->getByUserId(backpack_auth()->user()->id);
        return view('backpack.menus.menus',['id'=>$organization->id]);
    }

    public function statistics()
    {
        if (!backpack_auth()->user()) {
            return redirect('/admin/login');
        }
        $organization   =   $this->organizationService->getByUserId(backpack_auth()->user()->id);
        return view('backpack.statistics.statistics',['id'=>$organization->id]);
    }

    public function photos()
    {
        if (!backpack_auth()->user()) {
            return redirect('/admin/login');
        }
        $organization   =   $this->organizationService->getByUserId(backpack_auth()->user()->id);
        return view('backpack.photos.photos',['id'=>$organization->id]);
    }

    public function room()
    {
        if (!backpack_auth()->user()) {
            return redirect('/admin/login');
        }
        $organization   =   $this->organizationService->getByUserId(backpack_auth()->user()->id);
        return view('backpack.room.room',['id'=>$organization->id]);
    }

    public function news_main()
    {
        if (!backpack_auth()->user()) {
            return redirect('/admin/login');
        } elseif ($organization   =   $this->organizationService->getByUserId(backpack_auth()->user()->id)) {
            return view('backpack.news.news',['id'=>$organization->id]);
        }
        return response('',404);
    }

    public function dashboardBooking($id)
    {
        $table  =   $this->organizationTableListService->getById($id);
        return view('vendor.backpack.base.booking',compact('table'));
    }

    public function index()
    {
        return view('index',[
            'title' =>  'Reserved | Добро пожаловать',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function search()
    {
        return view('index', [
            'title' =>  'Поиск',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function favorite()
    {
        return view('index', [
            'title' =>  'Избранное',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function news()
    {
        return view('index', [
            'title' =>  'Новости',
            'description'   =>  'Свежие новости reserved',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function politics()
    {
        return view('index', [
            'title' =>  'Политика конфеденциальности',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function contacts()
    {
        return view('index', [
            'title' =>  'Контакты',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function support()
    {
        return view('index', [
            'title' =>  'Служба поддержки',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function home()
    {
        return view('index', [
            'title' =>  'Категории',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function category($slug)
    {
        $category   =   $this->categoryService->getBySlug($slug);
        if ($category) {
            return view('index', [
                'title' =>  $category->{MainContract::TITLE},
                'description'   =>  $category->{MainContract::DESCRIPTION},
                'keywords'  =>  $this->tagsOptionService->list()
            ]);
        }
        return view('index',[
            'title' =>  'Не найдено',
            'description'   =>  '',
            'keywords'  =>  ''
        ]);
    }

    public function getOrganizationById($slug,$id)
    {
        $organization   =   $this->organizationService->getById($id);

        if ($organization) {
            WebTraffic::dispatch(
                date('Y-m-d'),
                $id,
                $this->webTrafficService->getRealIpAddress(),
                $this->webTrafficService->getReferer()
            );
            return view('index', [
                'title' =>  $organization->{MainContract::TITLE},
                'description'   =>  $organization->{MainContract::DESCRIPTION},
                'keywords'  =>  implode(', ',[
                    $organization->{MainContract::TITLE},
                    $organization->{MainContract::CATEGORY}->{MainContract::TITLE},
                    $organization->{MainContract::CATEGORY}->{MainContract::DESCRIPTION},
                    'Забронировать'
                ])
            ]);
        }

        return view('index',[
            'title' =>  'Не найдено'
        ]);
    }

    public function profile()
    {
        return view('index', [
            'title' =>  'Профиль',
            'description'   =>  'Личный кабинет',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function upload() {
        return '';
        //if($request->hasFile('profile_image')) {
    }

    public function form()
    {
        return view('index', [
            'title' => 'Заявка для ресторанов',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function profileSettings()
    {
        return view('index', [
            'title'=>'Уведомления',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function profilePayments()
    {
        return view('index', [
            'title' =>  'Способ оплаты',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

    public function profileHistory()
    {
        return view('index', [
            'title' =>  'История бронирования',
            'description'   =>  '',
            'keywords'  =>  $this->tagsOptionService->list()
        ]);
    }

}
