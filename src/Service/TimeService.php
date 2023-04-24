<?php

namespace App\Service;

use App\Exception\TimeStartErrorException;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class TimeService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UsersRepository $usersRepository,
        private readonly Security $security)
    {
    }

    public function startTime(): void
    {
        $id = $this->security->getUser()->getUserIdentifier();
        $user = $this->usersRepository->getUserById($id);
        $date = new \DateTime();

        $numberOfWeekCurrent = $date->format('W');
        $weeks = $user->getPerWeekHours();
        if (null == $weeks || !array_key_exists($numberOfWeekCurrent, $weeks)) {
            $weeks[$numberOfWeekCurrent] = 0;
        }

        $user->setDateStart($date)->setPerWeekHours($weeks);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function stopTime(): void
    {
        $id = $this->security->getUser()->getUserIdentifier();
        $user = $this->usersRepository->getUserById($id);
        $date = new \DateTime();

        if (null === $user->getDateStart()) {
            throw new TimeStartErrorException();
        } else {
            $interval = $user->getDateStart()->diff($date);
            $hour = $interval->format('%h');
            $min = $interval->format('%i');
            $sec = $interval->format('%s');
            $timeSec = $sec + $min * 60 + $hour * 3600;
        }
        $weeks = $user->getPerWeekHours();
        $numberOfWeekCurrent = $date->format('W');
        foreach ($weeks as $key => $value) {
            if ($key == $numberOfWeekCurrent) {
                $weeks[$key] = $value + strval($timeSec);
            }
        }

        $user->setPerWeekHours($weeks)
            ->setDateStart(null)
            ->setDateStop(null);
        $this->em->persist($user);
        $this->em->flush();
    }
}
