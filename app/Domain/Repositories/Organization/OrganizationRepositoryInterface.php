<?php


namespace App\Domain\Repositories\Organization;


interface OrganizationRepositoryInterface
{
    public function getIdsByUserId(int $userId);
    public function list(int $paginate);
    public function getById($id);
    public function getByCategoryId(int $id, int $paginate);
}
