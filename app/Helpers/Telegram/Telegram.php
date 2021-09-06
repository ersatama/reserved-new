<?php

namespace App\Helpers\Telegram;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\OrganizationTableListContract;
use App\Domain\Contracts\OrganizationTablesContract;
use App\Domain\Contracts\TelegramChatContract;
use App\Domain\Contracts\TelegramContract;
use App\Domain\Contracts\UserContract;
use App\Helpers\Curl\Curl;
use App\Services\User\UserService;
use App\Services\OrganizationTable\OrganizationTableService;
use App\Services\OrganizationTableList\OrganizationTableListService;

use App\Models\Booking;
use App\Models\Review;

use App\Services\TelegramChat\TelegramChatService;
use Illuminate\Support\Facades\Log;

class Telegram
{
    protected $curl;
    protected $userService;
    protected $organizationTableListService;
    protected $organizationTableService;
    protected $telegramChatService;

    public function __construct(Curl $curl, UserService $userService, OrganizationTableListService $organizationTableListService, OrganizationTableService $organizationTableService, TelegramChatService $telegramChatService)
    {
        $this->curl =   $curl;
        $this->userService  =   $userService;
        $this->organizationTableListService =   $organizationTableListService;
        $this->organizationTableService =   $organizationTableService;
        $this->telegramChatService  =   $telegramChatService;
    }

    public function setWebhook($id, $token)
    {
        $this->curl->getSend($this->urlHook($id, $token));
    }

    public function booking($telegrams, Booking $booking)
    {
        foreach ($telegrams as &$telegram) {
            if ($telegram->{TelegramContract::STATUS}   === TelegramContract::ALL || $telegram->{TelegramContract::STATUS}   === TelegramContract::BOOKINGS) {
                $chatIds    =   $this->getChatIds($telegram);
                foreach ($chatIds as &$chatId) {
                    $this->send($telegram, $chatId, $booking);
                }
            }
        }
    }

    public function review($telegrams, Review $review, $booking)
    {
        foreach ($telegrams as &$telegram) {
            if ($telegram->{TelegramContract::STATUS}   === TelegramContract::ALL || $telegram->{TelegramContract::STATUS}   === TelegramContract::REVIEWS) {
                $chatIds    =   $this->getChatIds($telegram);
                foreach ($chatIds as &$chatId) {
                    $this->sendReview($telegram, $chatId, $review, $booking);
                }
            }
        }
    }

    public function sendReview($telegram, $chatId, Review $review, $booking)
    {
        $this->curl->postSend($this->urlMessage($telegram),[
            'chat_id'   =>  $chatId,
            'text'      =>  $this->reviewText($review, $booking)
        ]);
    }

    public function send($telegram, $chatId, Booking $booking)
    {
        $this->curl->postSend($this->urlMessage($telegram),[
            'chat_id'   =>  $chatId,
            'text'      =>  $this->bookingText($booking)
        ]);
    }

    public function getChatIds($telegram)
    {
        $telegramChats  =   $this->telegramChatService->getByTelegramId($telegram->{TelegramContract::ID});
        $arr    =   [];
        foreach ($telegramChats as &$telegramChat) {
            $arr[]  =   $telegramChat->{TelegramChatContract::TELEGRAM_CHAT_ID};
        }
        Log::info('chats'.$telegram->{TelegramContract::ID});
        return $arr;
    }

    public function reviewText(Review $review, $booking)
    {
        $message    =   $this->ratingEmoji($review->rating).' Новый отзыв'."\n\n";

        $message    .=  '🍽 '.$booking->organizationTables->{BookingContract::TITLE}."\n";
        $message    .=  '📋 ID: '.$booking->{BookingContract::ID}."\n";
        $message    .=  '📅 Дата: '.$booking->{BookingContract::DATE}."\n";
        $message    .=  '⏰ Время: '.$booking->{BookingContract::TIME}."\n";

        $section    =   $this->organizationTableService->getById($booking->organizationTables->{OrganizationTableListContract::ORGANIZATION_TABLE_ID});
        if ($section) {
            $message    .=  '📌 Секция: '.$section->{OrganizationTablesContract::NAME}."\n\n";
        }

        $user   =   $this->userService->getById($booking->{BookingContract::USER_ID});

        $message    .=  '✏️Имя: '.$user->{UserContract::NAME}."\n";
        $message    .=  '📞 Телефон: +'.$user->{UserContract::PHONE}."\n\n";

        $message    .=  'Рейтинг: '.str_repeat('⭐ ', $review->rating);
        $message    .=  "\n\n";
        $message    .=  'Комментарии: '.$review->comment;
        return $message;
    }

    public function ratingEmoji($rating)
    {
        $emoji  =   '😍';
        if (intVal($rating) === 4) {
            $emoji  =   '☺';
        } elseif (intVal($rating) === 3) {
            $emoji  =   '🤨';
        } elseif (intVal($rating) === 2) {
            $emoji  =   '😤';
        } elseif (intVal($rating) === 1) {
            $emoji  =   '😡';
        }
        return $emoji;
    }

    public function bookingText(Booking $booking)
    {

        $user   =   $this->userService->getById($booking->{BookingContract::USER_ID});
        $table  =   $this->organizationTableListService->getById($booking->{BookingContract::ORGANIZATION_TABLE_LIST_ID});


        $message    =   '✉️Бронирование '.$table->{BookingContract::TITLE}."\n\n";
        $message    .=  '📋 ID: '.$booking->{BookingContract::ID}."\n";
        $message    .=  '📅 Дата: '.$booking->{BookingContract::DATE}."\n";
        $message    .=  '⏰ Время: '.$booking->{BookingContract::TIME}."\n";

        $section    =   $this->organizationTableService->getById($table->{OrganizationTableListContract::ORGANIZATION_TABLE_ID});
        if ($section) {
            $message    .=  '📌 Секция: '.$section->{OrganizationTablesContract::NAME}."\n\n";
        }

        $message    .=  '✏️Имя: '.$user->{UserContract::NAME}."\n";
        $message    .=  '📞 Телефон: +'.$user->{UserContract::PHONE};
        return $message;
    }

    public function urlMessage($telegram)
    {
        return 'https://api.telegram.org/bot'.$telegram->{TelegramContract::API_TOKEN}.'/sendMessage';
    }

    public function urlUpdates($telegram): string
    {
        return 'https://api.telegram.org/bot'.$telegram->{TelegramContract::API_TOKEN}.'/getUpdates';
    }

    public function urlHook($id,$token): string
    {
        return 'https://api.telegram.org/bot'.$token.'/setWebhook?url=https://reserved-app.kz/api/telegram_chat/create/'.$id;
    }

}
