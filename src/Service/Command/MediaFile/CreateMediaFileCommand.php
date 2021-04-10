<?php


namespace App\Service\Command\MediaFile;


class CreateMediaFileCommand
{
    protected $url;


    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }


}