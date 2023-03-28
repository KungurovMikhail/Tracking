<?php

namespace App\Service;

use App\Exception\TimeStartError;
use App\Repository\UsersRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

class TimeService
{
    public function __construct(
        private EntityManagerInterface $em,
        private UsersRepository $usersRepository
    )
    {
    }

    public function startTime(int $id): void
    {
        $user = $this->usersRepository->getUserById($id);
        $date = new DateTime();
        
        $numberOfWeekCurrent = $date->format('W');
        $weeks = $user->getPerWeekHours();
        if ($weeks == null || !array_key_exists($numberOfWeekCurrent, $weeks)) {
            $weeks[$numberOfWeekCurrent] = 0;
        }

        $user->setDateStart($date)->setPerWeekHours($weeks);
        $this->em->persist($user);
        $this->em->flush();
    }

    public function stopTime(int $id): void
    {
        $user = $this->usersRepository->getUserById($id);
        $date = new DateTime();

        if ($user->getDateStart() === null) {
            throw new TimeStartError();
        } else {
            $interval = ($user->getDateStart())->diff($date);
            $hour = $interval->format("%h");
            $min = $interval->format("%i");
            $sec = $interval->format("%s");
            $timeSec = $sec + $min*60 + $hour*3600;
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
