<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ShareMessage extends Message
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $host;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ogTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ogDescription;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ogImage;

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link): void
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     */
    public function setHost($host): void
    {
        $this->host = $host;
    }

    /**
     * @return mixed
     */
    public function getOgTitle()
    {
        return $this->ogTitle;
    }

    /**
     * @param mixed $ogTitle
     */
    public function setOgTitle($ogTitle): void
    {
        $this->ogTitle = $ogTitle;
    }

    /**
     * @return mixed
     */
    public function getOgDescription()
    {
        return $this->ogDescription;
    }

    /**
     * @param mixed $ogDescription
     */
    public function setOgDescription($ogDescription): void
    {
        $this->ogDescription = $ogDescription;
    }

    /**
     * @return mixed
     */
    public function getOgImage()
    {
        return $this->ogImage;
    }

    /**
     * @param mixed $ogImage
     */
    public function setOgImage($ogImage): void
    {
        $this->ogImage = $ogImage;
    }
}
