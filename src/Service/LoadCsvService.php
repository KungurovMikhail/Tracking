<?php

namespace App\Service;

use App\Entity\Users;
use App\Exception\FileFormatException;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\HttpFoundation\Request;

class LoadCsvService
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function load(Request $request, string $path): void
    {
        $file = $request->files->get('file');
        $extensionFile = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        if ($extensionFile != 'csv') {
            throw new FileFormatException();
        } else {
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $newFileName = $originalFileName.'.'.$extensionFile;
        }

        $file->move($path, $newFileName);
        $csv = Reader::createFromPath($path.'/'.$newFileName, 'r');

        $records = $csv->getRecords();
        foreach ($records as $record) {
            $user = new Users();
            $user->setName(implode($record))
                ->setRoles(['ROLE_USER'])
                ->setApiToken(hash('sha256', rand()));
            $this->em->persist($user);
        }
        $this->em->flush();
    }
}
