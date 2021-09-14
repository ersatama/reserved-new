<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NewsSubscribe\NewsSubscribeService;
use App\Http\Requests\NewsSubscribe\NewsSubscribeCreateRequest;
use App\Http\Requests\NewsSubscribe\NewsSubscribeUpdateRequest;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\NewsSubscribe\NewsSubscribeResource;
use App\Http\Resources\NewsSubscribe\NewsSubscribeCollection;

class NewsSubscribeController extends Controller
{
    protected $newsSubscribeService;
    public function __construct(NewsSubscribeService $newsSubscribeService)
    {
        $this->newsSubscribeService =   $newsSubscribeService;
    }

    /**
     * @throws ValidationException
     */
    public function create(NewsSubscribeCreateRequest $newsSubscribeCreateRequest): NewsSubscribeResource
    {
        return new NewsSubscribeResource($this->newsSubscribeService->create($newsSubscribeCreateRequest->validated()));
    }

    /**
     * @throws ValidationException
     */
    public function update($id, NewsSubscribeUpdateRequest $newsSubscribeUpdateRequest)
    {
        $this->newsSubscribeService->update($id, $newsSubscribeUpdateRequest->validated());
    }

    public function getByOrganizationIdAndUserId($organizationId, $userId)
    {
        if ($newsSubscribe  =   $this->newsSubscribeService->getByOrganizationIdAndUserId($organizationId, $userId)) {
            return new NewsSubscribeResource($newsSubscribe);
        }
        return response(['message'  =>  'Not Found'],404);
    }

}
