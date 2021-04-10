<?php


namespace App\Service\Command\MediaFile;


use App\Entity\MediaFile;
use Doctrine\ORM\EntityManager;

class DeleteMediaFileHandler
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function handle(DeleteMediaFileCommand $command)
    {
        $mediafile = $this->em->getRepository(MediaFile::class)->find($command->getId());
        if ($mediafile) {
            $this->em->remove($mediafile);
            $this->em->flush();
            return $command->getId();
        }
        return null;
    }

}