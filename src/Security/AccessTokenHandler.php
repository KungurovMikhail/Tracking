<?php

namespace App\Security;

use App\Exception\InvalidAccessTokenException;
use App\Repository\UsersRepository;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

class AccessTokenHandler implements AccessTokenHandlerInterface
{
    public function __construct(private readonly UsersRepository $usersRepository)
    {
    }

    public function getUserBadgeFrom(string $accessToken): UserBadge
    {
        if ($this->usersRepository->exsistsByAccessToken($accessToken)) {
            throw new InvalidAccessTokenException();
        }
        $id = $this->usersRepository->findIdByToken($accessToken);
        return new UserBadge($id);
    }
}
