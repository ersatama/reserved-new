<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\TelegramChatContract;
use App\Domain\Contracts\TelegramContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\Telegram\TelegramResource;
use App\Models\TelegramChat;
use Illuminate\Http\Request;
use App\Services\Telegram\TelegramService;

use App\Http\Resources\Telegram\TelegramCollection;

use App\Http\Requests\Telegram\TelegramWebhookRequest;

use App\Services\TelegramChat\TelegramChatService;
use Illuminate\Validation\ValidationException;

class TelegramController extends Controller
{

    protected $telegramService;
    protected $telegramChatService;

    public function __construct(TelegramService $telegramService, TelegramChatService $telegramChatService)
    {
        $this->telegramService  =   $telegramService;
        $this->telegramChatService  =   $telegramChatService;
    }

    public function getByUserId($userId): TelegramCollection
    {
        return new TelegramCollection($this->telegramService->getByUserId($userId));
    }

    public function getById($id)
    {
       if ($telegram   =   $this->telegramService->getById($id)) {
           return new TelegramResource($telegram);
       }
        return response(['message'  =>  'Телеграм не найден'],404);
    }

}
