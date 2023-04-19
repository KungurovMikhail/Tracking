<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<Users>
 *
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    public function getUserById(int $id): Users
    {
        $user = $this->find($id);
        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function getListIdAndName(): array
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('q.id', 'q.name')
            ->from('App\Entity\Users', 'q')
            ->orderBy('q.id');
        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function findIdByToken(string $accessToken): int
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('q.id')
            ->from('App\Entity\Users', 'q')
            ->where('q.apiToken = :token')
            ->setParameter('token', $accessToken);
        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function exsistsByAccessToken(string $accessToken): bool
    {
        return null == $this->findOneBy(['apiToken' => $accessToken]);
    }
}
