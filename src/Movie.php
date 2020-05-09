<?php
namespace Azatnizam;

final class Movie
{
    private $id;
    private $title;
    private $popularity;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return Movie
     */
    public function setId($id): Movie
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return Movie
     */
    public function setTitle($title): Movie
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPopularity()
    {
        return $this->popularity;
    }

    /**
     * @param $popularity
     * @return Movie
     */
    public function setPopularity($popularity): Movie
    {
        $this->popularity = $popularity;
        return $this;
    }
}