<?php

namespace App\Command;

use App\Entity\MediaFile;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ClearDeletedCommand extends Command
{
    protected static $defaultName = 'app:clear-deleted';
    protected static $defaultDescription = 'Erasing already deleted MediaFiles from filesystem ';
    private $em;
    private $cacheManager;
    private $storage;

    public function __construct(EntityManagerInterface $em, CacheManager $cacheManager, $publicMediaStorage)
    {
        $this->em = $em;
        $this->cacheManager = $cacheManager;
        $this->storage = $publicMediaStorage;
        parent::__construct();
    }


    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->em->getFilters()->disable('softdeleteable');

        $mediaFiles = $this->em->getRepository(MediaFile::class)->findExpired();

        foreach ($mediaFiles as $mediaFile){
            $cachePath = substr($this->cacheManager->getBrowserPath($mediaFile->getPath(), 'thumb'), 9);
            if ($this->storage->fileExists($mediaFile->getPath())){
                $this->storage->delete($mediaFile->getPath());
            }
            if ($this->storage->fileExists($cachePath)){
                $this->storage->delete($cachePath);
            }
        }

        $io->success('Done!');

        return Command::SUCCESS;
    }
}
