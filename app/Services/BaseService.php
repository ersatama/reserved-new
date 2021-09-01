<?php


namespace App\Services;


abstract class BaseService
{
    public $repo;

    public function all()
    {
        return $this->repo->all();
    }

    public function paginated()
    {
        return $this->repo->paginated(config('paginate'));
    }
    public function create(array $data)
    {
        return $this->repo->create($data);
    }
    public function find($id)
    {
        return $this->repo->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->repo->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repo->destroy($id);
    }
}
