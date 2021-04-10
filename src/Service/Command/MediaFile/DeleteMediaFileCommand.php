<?php


namespace App\Service\Command\MediaFile;


class DeleteMediaFileCommand
{
    protected $id;


    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }


}