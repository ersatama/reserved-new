<?php

namespace App\Domain\Repositories\Booking;

use App\Domain\Contracts\UserContract;
use App\Events\BookingNotification;
use App\Events\BookingOrganizationNotification;
use App\Jobs\TelegramNotification;
use App\Jobs\BookingNewNotification;
use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\BookingContract;
use App\Helpers\Time\Time;
use App\Models\Booking;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BookingRepositoryEloquent implements BookingRepositoryInterface
{
    protected $take =   15;
    protected $date;

    public function __construct(Time $time)
    {
        $this->date =   $time->modify('-15 minutes');
    }

    public function updateIikoId(int $id, string $iikoId):void
    {
        Booking::where(MainContract::ID,$id)->update([
            MainContract::IIKO_BOOKING_ID    =>  $iikoId
        ]);
    }

    public function create(array $data)
    {
        $booking    =   Booking::create($data);
        if ($booking->{MainContract::STATUS} == MainContract::ON) {
            TelegramNotification::dispatch($booking);
            BookingNewNotification::dispatch($booking);
        }
        if ($booking->{MainContract::STATUS} != MainContract::OFF) {
            $booking    =   $this->getById($booking->id);
            event(new BookingNotification($booking));
            event(new BookingOrganizationNotification($booking));
        }
        return $booking;
    }

    public function ids($date, $ids): array
    {
        $data   =   [];
        foreach ($ids as &$id) {
            $data[] =   Booking::with('user')
                ->where([
                    [MainContract::ORGANIZATION_TABLE_LIST_ID,$id],
                    [MainContract::DATE,$date],
                    [MainContract::STATUS, MainContract::ON],
                ])->orWhere([
                    [MainContract::ORGANIZATION_TABLE_LIST_ID,$id],
                    [MainContract::DATE,$date],
                    [MainContract::STATUS, MainContract::CAME],
                ])->orWhere([
                    [MainContract::ORGANIZATION_TABLE_LIST_ID,$id],
                    [MainContract::DATE,$date],
                    [MainContract::STATUS, MainContract::CHECKING],
                    [MainContract::CREATED_AT,'>=',$this->date]
                ])
                ->orderBy(MainContract::ID, MainContract::DESC)
                ->first();
        }
        return $data;
    }

    public function update($id, array $data):void
    {
        $booking    =   $this->getById($id);
        if (array_key_exists(MainContract::STATUS,$data) && $data[MainContract::STATUS] === MainContract::ON) {
            TelegramNotification::dispatch($booking);
            BookingNewNotification::dispatch($booking);
        }
        event(new BookingNotification($booking));
        event(new BookingOrganizationNotification($booking));
        Booking::where(MainContract::ID,$id)->update($data);
    }

    public function getCompletedByUserId($userId):object
    {
        return Booking::with('user','organization','organizationTables')
            ->where([
                [MainContract::USER_ID,$userId],
                [MainContract::STATUS, MainContract::COMPLETED],
                [MainContract::COMMENT, MainContract::ON]
            ])
            ->orderBy(MainContract::ID, MainContract::DESC)
            ->get();
    }

    public function getByBetweenDateAndOrganizationId($start,$end,$organizationId): Collection
    {
        return DB::table(BookingContract::TABLE)
            ->select(MainContract::DATE,DB::raw('count(*) as total'))
            ->where([
                [MainContract::ORGANIZATION_ID,$organizationId],
                [MainContract::STATUS,MainContract::COMPLETED]
            ])
            ->whereDate(MainContract::DATE,'>=',date('Y-m-d',strtotime($start)))
            ->whereDate(MainContract::DATE,'<=',date('Y-m-d',strtotime($end)))
            ->groupBy(MainContract::DATE)
            ->get();
    }

    public function getLastByTableId($id,$date)
    {
        return $this->getOneMultiple([MainContract::ORGANIZATION_TABLE_LIST_ID,$id],[MainContract::DATE,$date]);
    }

    public function getOneMultiple($query, $query2)
    {
        return Booking::with('user','organization','organizationTables')
            ->where([
                $query,
                $query2,
                [MainContract::STATUS, MainContract::ON],
            ])
            ->orWhere([
                $query,
                $query2,
                [MainContract::STATUS, MainContract::CAME],
            ])
            ->orWhere([
                $query,
                $query2,
                [MainContract::STATUS, MainContract::COMPLETED],
            ])
            ->orWhere([
                $query,
                $query2,
                [MainContract::STATUS, MainContract::CHECKING],
                [MainContract::CREATED_AT,'>=',$this->date]
            ])
            ->orderBy(MainContract::ID, MainContract::DESC)
            ->first();
    }

    public function getById($id)
    {
        return $this->getOne([MainContract::ID,$id]);
    }

    public function getOne($query)
    {
        return Booking::with('user','organization','organizationTables')
            ->where([
                $query,
                [MainContract::STATUS, MainContract::ON]
            ])
            ->orWhere([
                $query,
                [MainContract::STATUS, MainContract::CAME],
            ])
            ->orWhere([
                $query,
                [MainContract::STATUS, MainContract::COMPLETED],
            ])
            ->orWhere([
                $query,
                [MainContract::STATUS, MainContract::CHECKING],
                [MainContract::CREATED_AT,'>=',$this->date]
            ])->first();
    }

    public function getByUserId($userId,$paginate):object
    {
        return $this->get([MainContract::USER_ID,$userId],$paginate);
    }
    public function getByOrganizationId($organizationId,$paginate):object
    {
        return $this->get([MainContract::ORGANIZATION_ID,$organizationId],$paginate);
    }
    public function getByTableId($tableId,$paginate):object
    {
        return $this->get([MainContract::ORGANIZATION_TABLE_LIST_ID,$tableId],$paginate);
    }
    public function getByDate($date,$paginate):object
    {
        return $this->get([MainContract::DATE,$date],$paginate);
    }
    public function get($query, $paginate):object
    {
        return Booking::with('user','organization','organizationTables')
            ->where([
                $query,
                [MainContract::STATUS, MainContract::ON]
            ])
            ->orWhere([
                $query,
                [MainContract::STATUS, MainContract::CAME],
            ])
            ->orWhere([
                $query,
                [MainContract::STATUS, MainContract::COMPLETED],
            ])
            ->orWhere([
                $query,
                [MainContract::STATUS, MainContract::CHECKING],
                [MainContract::CREATED_AT,'>=',$this->date]
            ])
            ->orderBy(MainContract::ID, MainContract::DESC)
            ->skip($paginate * $this->take)
            ->take($this->take)->get();
    }

}
