<?php

namespace App\Http\Controllers\Api;

use App\Domain\Contracts\MainContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\TelegramChat\TelegramChatUpdateRequest;
use App\Http\Requests\TelegramChat\TelegramChatCreateRequest;
use App\Services\TelegramChat\TelegramChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TelegramChatController extends Controller
{
    protected $telegramChatService;

    public function __construct(TelegramChatService $telegramChatService)
    {
        $this->telegramChatService =   $telegramChatService;
    }

    /**
     * @throws ValidationException
     */
    public function create($id, Request $telegramChatCreateRequest)
    {
        Log::info('webhook-'.$id,[$telegramChatCreateRequest->all()]);
        $message    =   $telegramChatCreateRequest->all()[MainContract::MESSAGE];
        $chat       =   $message[MainContract::CHAT][MainContract::ID];
        if (!$this->telegramChatService->getByChatId($chat)) {
            $this->telegramChatService->create([
                MainContract::TELEGRAM_ID       =>  $id,
                MainContract::TELEGRAM_CHAT_ID  =>  $chat,
            ]);
        } elseif (array_key_exists(MainContract::TEXT,$message) && $message[MainContract::TEXT] === '/start') {
            $this->telegramChatService->update($chat, [
                MainContract::STATUS    =>  MainContract::ON
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function update($id, TelegramChatUpdateRequest $telegramChatUpdateRequest):void
    {
        $this->telegramChatService->update($id, $telegramChatUpdateRequest->validated());
    }

}
