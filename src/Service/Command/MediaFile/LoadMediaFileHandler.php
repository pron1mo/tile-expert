<?php


namespace App\Service\Command\MediaFile;


use App\Entity\MediaFile;
use Doctrine\ORM\EntityManager;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;

class LoadMediaFileHandler
{
    private $em;
    private $cacheManager;

    public function __construct(EntityManager $em, CacheManager $cacheManager)
    {
        $this->em = $em;
        $this->cacheManager = $cacheManager;
    }


    public function handle(LoadMediaFileCommand $command)
    {
        $mediafiles = $this->em->getRepository(MediaFile::class)->findBy(['id' => $command->getIds()]);
        if ($mediafiles) {
            $response = [];
            foreach ($mediafiles as $file) {
                $response[] = [
                    'id' => $file->getId(),
                    'src' => $this->cacheManager->getBrowserPath($file->getPath(), 'thumb')
                ];
            }
            return $response;
        }
        return null;
    }

}