<?php

namespace App\Security;

use App\Exception\BadCredentialsException;
use App\Repository\UsersRepository;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(private UsersRepository $usersRepository)
    {
    }

    public function getUserBadgeFrom(string $apiToken): UserBadge
    {
        $id = $this->usersRepository->findIdByToken($apiToken);
        if (null === $id) { //валидацию
            throw new BadCredentialsException();
        }

        return new UserBadge($id);
    }
}
