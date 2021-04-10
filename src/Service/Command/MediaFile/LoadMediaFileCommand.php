<?php


namespace App\Service\Command\MediaFile;


class LoadMediaFileCommand
{
    protected $ids;


    public function __construct(array $ids)
    {
        $this->ids = $ids;
    }

    /**
     * @return array
     */
    public function getIds(): array
    {
        return $this->ids;
    }


}