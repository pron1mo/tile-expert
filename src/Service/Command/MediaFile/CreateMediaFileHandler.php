<?php


namespace App\Service\Command\MediaFile;


use App\Entity\MediaFile;
use Doctrine\ORM\EntityManager;
use Exception;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Liip\ImagineBundle\Service\FilterService;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateMediaFileHandler
{
    private $em;
    private $imagineFilter;
    private $imagineManager;
    private $storage;
    private $allowedMimeTypes;

    public function __construct(EntityManager $em, FilterService $imagineFilter, CacheManager $imagineManager, $publicMediaStorage)
    {
        $this->em = $em;
        $this->imagineFilter = $imagineFilter;
        $this->imagineManager = $imagineManager;
        $this->storage = $publicMediaStorage;
        $this->allowedMimeTypes = ['image/jpeg', 'image/png'];
    }

    public function handle(CreateMediaFileCommand $command)
    {
        try {
            $exif = exif_read_data($command->getUrl(), 'FILE, COMPUTED', true);
        } catch (\Exception $e) {
            return 'Ссылка без изображения. Попробуйте ввести другую';
        }

        $mimeType = $exif["FILE"]["MimeType"];
        $fileSize = $exif["FILE"]["FileSize"];
        $acceptedResolution = ($exif["COMPUTED"]["Height"] >= 200 && $exif["COMPUTED"]["Width"] >= 200);
        if ($exif && in_array($mimeType, $this->allowedMimeTypes) && $acceptedResolution) {

            $stream = file_get_contents($command->getUrl());
            $filename = sha1(uniqid(Uuid::uuid4(), true)) . '.';
            $result = $this->storage->write('media/' . $filename . 'png', $stream);

            if ($result === false) {
                return 'Не удалось сохранить загружаемый файл.';
            }

            $media = new MediaFile();
            $media->setFilename($filename . 'png');
            $media->setPath('media/' . $filename . 'png');
            $media->setMimeType($mimeType);
            $media->setSize($fileSize);
            $this->em->persist($media);
            $this->em->flush();

            $this->imagineFilter->getUrlOfFilteredImage($media->getPath(), 'thumb');

            $url = $this->imagineManager->getBrowserPath($media->getPath(), 'thumb');
            return [
                'id' => $media->getId(),
                'src' => $url
            ];
        } else {
            return 'Не подходящий файл, попробуйте ввести другой URL.';
        }
    }


}