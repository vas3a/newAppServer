<?php

namespace Wimp\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VideoModel
 *
 * @ORM\Table(name="wimp_videos")
 * @ORM\Entity(repositoryClass="Wimp\AppBundle\Entity\VideoModelRepository")
 */
class VideoModel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="secondTitle", type="string", length=255)
     */
    private $secondTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="thumbnailPath", type="string", length=255)
     */
    private $thumbnailPath;

    /**
     * @var string
     *
     * @ORM\Column(name="videoPath", type="string", length=255)
     */
    private $videoPath;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return VideoModel
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set secondTitle
     *
     * @param string $secondTitle
     * @return VideoModel
     */
    public function setSecondTitle($secondTitle)
    {
        $this->secondTitle = $secondTitle;
    
        return $this;
    }

    /**
     * Get secondTitle
     *
     * @return string 
     */
    public function getSecondTitle()
    {
        return $this->secondTitle;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return VideoModel
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set thumbnailPath
     *
     * @param string $thumbnailPath
     * @return VideoModel
     */
    public function setThumbnailPath($thumbnailPath)
    {
        $this->thumbnailPath = $thumbnailPath;
    
        return $this;
    }

    /**
     * Get thumbnailPath
     *
     * @return string 
     */
    public function getThumbnailPath()
    {
        return $this->thumbnailPath;
    }

    /**
     * Set videoPath
     *
     * @param string $videoPath
     * @return VideoModel
     */
    public function setVideoPath($videoPath)
    {
        $this->videoPath = $videoPath;
    
        return $this;
    }

    /**
     * Get videoPath
     *
     * @return string 
     */
    public function getVideoPath()
    {
        return $this->videoPath;
    }
}
