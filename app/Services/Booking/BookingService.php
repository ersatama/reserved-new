<?php


namespace App\Services\Booking;


use App\Domain\Contracts\MainContract;
use App\Services\BaseService;

use App\Domain\Repositories\Booking\BookingRepositoryInterface;
use App\Domain\Repositories\Organization\OrganizationRepositoryInterface;

use App\Domain\Contracts\BookingContract;
use App\Domain\Contracts\OrganizationContract;
use Carbon\Carbon;
use http\Env\Request;

class BookingService extends BaseService
{
    protected $bookingRepository;
    protected $organizationRepository;

    public function __construct(BookingRepositoryInterface $bookingRepository, OrganizationRepositoryInterface $organizationRepository)
    {
        $this->bookingRepository    =   $bookingRepository;
        $this->organizationRepository   =   $organizationRepository;
    }

    public function getById($id)
    {
        return $this->bookingRepository->getById($id);
    }

    public function getByUserId($userId,int $paginate):object
    {
        return $this->bookingRepository->getByUserId($userId,$paginate);
    }

    public function getByOrganizationId($organizationId, int $paginate):object
    {
        return $this->bookingRepository->getByOrganizationId($organizationId,$paginate);
    }

    public function getByTableId($tableId, int $paginate):object
    {
        return $this->bookingRepository->getByTableId($tableId, $paginate);
    }

    public function getByDate($date, int $paginate):object
    {
        return $this->bookingRepository->getByDate($date, $paginate);
    }

    public function getCompletedByUserId($userId): object
    {
        return $this->bookingRepository->getCompletedByUserId($userId);
    }

    public function getByBetweenDateAndOrganizationId($start,$end,$organizationId)
    {
        return $this->bookingRepository->getByBetweenDateAndOrganizationId($start,$end,$organizationId);
    }

    public function create(array $data)
    {
        return $this->bookingRepository->create($data);
    }

    public function ids($date, $ids): array
    {
        return $this->bookingRepository->ids($date, $ids);
    }

    public function update($id, array $data):void
    {
        $this->bookingRepository->update($id, $data);
    }

    public function result($data):bool
    {
        if ((int) $data[MainContract::PG_RESULT] === 1) {
            $this->bookingRepository->update($data[MainContract::PG_ORDER_ID],[
                MainContract::STATUS    =>  MainContract::ON
            ]);
            return true;
        }
        $this->bookingRepository->update($data[MainContract::PG_ORDER_ID],[
            MainContract::STATUS    =>  MainContract::OFF
        ]);
        return false;
    }

    public function getLastByTableId($id, $date) {
        return $this->bookingRepository->getLastByTableId($id, date('Y-m-d',strtotime($date)));
    }

}
