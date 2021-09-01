<?php

namespace App\Domain\Contracts;

class TelegramChatContract extends MainContract
{
    const TABLE =   'telegram_chats';

    const FILLABLE  =   [
        self::TELEGRAM_ID,
        self::TELEGRAM_CHAT_ID,
        self::STATUS
    ];
}
