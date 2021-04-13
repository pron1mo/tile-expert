<?php


namespace App\Service\Command\MediaFile;


use App\Entity\MediaFile;
use Doctrine\ORM\EntityManager;

class DeleteMediaFileHandler
{
    private $em;
    private $storage;

    public function __construct(EntityManager $em, $publicMediaStorage)
    {
        $this->em = $em;
        $this->storage = $publicMediaStorage;
    }


    public function handle(DeleteMediaFileCommand $command)
    {
        $mediafile = $this->em->getRepository(MediaFile::class)->find($command->getId());
        if ($mediafile) {
            $this->em->remove($mediafile);
            $this->em->flush();
            if ($this->storage->fileExists($mediafile->getPath())){
                $this->storage->delete($mediafile->getPath());
            }
            return $command->getId();
        }
        return null;
    }

}