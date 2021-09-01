<?php

namespace App\Services\TelegramChat;

use App\Services\BaseService;
use App\Domain\Repositories\TelegramChat\TelegramChatRepositoryInterface;
use Illuminate\Support\Collection;

class TelegramChatService extends BaseService
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

    public function getByChatId($chatId)
    {
        return $this->telegramChatRepository->getByChatId($chatId);
    }

    public function update($id,$data):void
    {
        $this->telegramChatRepository->update($id,$data);
    }

}
