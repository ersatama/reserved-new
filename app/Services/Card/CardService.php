<?php


namespace App\Services\Card;

use App\Services\BaseService;
use App\Domain\Repositories\Card\CardRepositoryInterface;
use Illuminate\Support\Collection;

class CardService extends BaseService
{
    protected $cardRepository;
    public function __construct(CardRepositoryInterface $cardRepository)
    {
        $this->cardRepository   =   $cardRepository;
    }

    public function create(array $data)
    {
        return $this->cardRepository->create($data);
    }

    public function update($id, array $data):void
    {
        $this->cardRepository->update($id, $data);
    }

    public function getById($id)
    {
        return $this->cardRepository->getById($id);
    }

    public function getByUserId($userId): Collection
    {
        return $this->cardRepository->getByUserId($userId);
    }

}
