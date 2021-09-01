<?php


namespace App\Services\User;

use App\Services\BaseService;
use App\Domain\Repositories\User\UserRepositoryInterface;

class UserService extends BaseService
{
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository   =   $userRepository;
    }

    public function adminCreate(array $data)
    {
        return $this->userRepository->adminCreate($data);
    }

    public function create(array $data) {
        return $this->userRepository->create($data);
    }

    public function update($id, array $input)
    {
        return $this->userRepository->update($id, $input);
    }

    public function smsVerify($phone,$code) {
        return $this->userRepository->smsVerify($phone,$code);
    }

    public function smsResend($phone) {
        return $this->userRepository->smsResend($phone);
    }

    public function getByPhone(string $phone)
    {
        return $this->userRepository->getByPhone($phone);
    }

    public function getById($id) {
        return $this->userRepository->getById($id);
    }

    public function getByApiToken(string $token) {
        return $this->userRepository->getByApiToken($token);
    }

    public function getByPhoneAndPassword($phone) {
        return $this->userRepository->getByPhoneAndPassword($phone);
    }

    public function verifyCode(int $code) {
        if ((int) backpack_user()->code === $code) {
            return $this->userRepository->updatePhoneVerifiedAt();
        }
        return false;
    }
}
