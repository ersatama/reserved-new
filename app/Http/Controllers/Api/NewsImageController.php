<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\NewsImage\NewsImageCreateRequest;
use App\Http\Requests\NewsImage\NewsImageUpdateRequest;
use App\Services\NewsImage\NewsImageService;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\NewsImage\NewsImageResource;
use App\Http\Resources\NewsImage\NewsImageCollection;

class NewsImageController extends Controller
{
    protected $newsImageService;
    public function __construct(NewsImageService $newsImageService)
    {
        $this->newsImageService =   $newsImageService;
    }

    /**
     * @throws ValidationException
     */
    public function create(NewsImageCreateRequest $newsImageCreateRequest): NewsImageResource
    {
        return new NewsImageResource($this->newsImageService->create($newsImageCreateRequest->validated()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, NewsImageUpdateRequest $newsImageUpdateRequest)
    {
        $this->newsImageService->update($id, $newsImageUpdateRequest->validated());
    }

    public function getByNewsId($newsId): NewsImageCollection
    {
        return new NewsImageCollection($this->newsImageService->getByNewsId($newsId));
    }

    public function getById($id)
    {
        if ($newsImage = $this->newsImageService->getById($id)) {
            return new NewsImageResource($newsImage);
        }
        return response([MainContract::MESSAGE  =>  'Not Found'],404);
    }

}
