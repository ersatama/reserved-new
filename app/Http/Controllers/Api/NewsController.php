<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\News\NewsService;
use App\Services\NewsSubscribe\NewsSubscribeService;
use App\Services\NewsImage\NewsImageService;
use App\Http\Requests\News\NewsCreateRequest;
use App\Http\Requests\News\NewsUpdateRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\News\NewsCollection;
use App\Http\Resources\News\NewsResource;

class NewsController extends Controller
{
    protected $newsService;
    protected $newsImageService;
    protected $newsSubscribeService;
    public function __construct(NewsService $newsService, NewsImageService $newsImageService, NewsSubscribeService $newsSubscribeService)
    {
        $this->newsService  =   $newsService;
        $this->newsImageService =   $newsImageService;
        $this->newsSubscribeService =   $newsSubscribeService;
    }

    /**
     * @throws ValidationException
     */
    public function create(NewsCreateRequest $newsCreateRequest)
    {
        $data   =   $newsCreateRequest->validated();
        $news   =   $this->newsService->create($data);
        foreach ($data[MainContract::IMAGES] as &$image) {
            $this->newsImageService->create([
                MainContract::NEWS_ID   =>  $news->{MainContract::ID},
                MainContract::IMAGE     =>  $image
            ]);
        }
        return new NewsResource($this->newsService->getById($news->{MainContract::ID}));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, NewsUpdateRequest $newsUpdateRequest)
    {
        $this->newsService->update($id, $newsUpdateRequest->validated());
    }

    public function subscribes($userId, $page): NewsCollection
    {
        $ids    =   $this->newsSubscribeService->getOrganizationIdsByUserId($userId);
        return new NewsCollection($this->newsService->getByOrganizationIds($ids));
    }

    public function list($page): NewsCollection
    {
        return new NewsCollection($this->newsService->list($page));
    }

    public function getByOrganizationId($organizationId): NewsCollection
    {
        return new NewsCollection($this->newsService->getByOrganizationId($organizationId));
    }

    public function getByOrganizationIdAndStatus($organizationId, $status): NewsCollection
    {
        return new NewsCollection($this->newsService->getByOrganizationIdAndStatus($organizationId, $status));
    }

    public function getById($id)
    {
        if ($news = $this->newsService->getById($id)) {
            return new NewsResource($news);
        }
        return response([MainContract::MESSAGE  =>  'Not Found'],404);
    }

    public function getByIdAndStatus($id, $status)
    {
        if ($news = $this->newsService->getByIdAndStatus($id, $status)) {
            return new NewsResource($news);
        }
        return response([MainContract::MESSAGE  =>  'Not Found'],404);
    }

}
