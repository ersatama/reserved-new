<?php

namespace App\Services\TelegramChat;

use App\Services\BaseService;
use App\Domain\Repositories\TelegramChat\TelegramChatRepositoryInterface;
use Illuminate\Support\Collection;

class TelegramChatService
{
    protected $telegramChatRepository;
    public function __construct(TelegramChatRepositoryInterface $telegramChatRepository)
    {
        $this->telegramChatRepository   =   $telegramChatRepository;
    }

    public function create($data)
    {
        return $this->telegramChatRepository->create($data);
    }

    public function getByTelegramId($telegramId): Collection
    {
        return $this->telegramChatRepository->getByTelegramId($telegramId);
    }

    public function getByTelegramIdAndChatId($telegramId, $chatId, $status = 'on')
    {
        return $this->telegramChatRepository->getByTelegramIdAndChatId($telegramId, $chatId, $status = 'on');
    }

    public function update($telegramId, $chatId, $data):void
    {
        $this->telegramChatRepository->update($telegramId, $chatId, $data);
    }

}
