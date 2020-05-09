<?php
namespace Azatnizam;

final class User
{
    private const CACHE_DIR = 'users.cache';
    private $moviesCount;
    private $id;
    private $cacheFile;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->cacheFile = dirname(__DIR__) . '/' . self::CACHE_DIR . '/' . $this->id;

        if (file_exists($this->cacheFile)) {
            $cacheFile = file_get_contents($this->cacheFile);
            $this->moviesCount = (int) $cacheFile;
        } else {
            $this->moviesCount = 0;
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getMoviesCount(): int
    {
        return (int) $this->moviesCount;
    }

    /**
     * Local storage increment
     */
    public function incrMoviesCount()
    {
        $this->moviesCount++;
        file_put_contents($this->cacheFile, (string) $this->moviesCount);
    }

    /**
     * @param int $counter
     * Use to synchronise with server counter
     */
    public function setMoviesCount(int $counter)
    {
        $this->moviesCount = $counter;
        file_put_contents($this->cacheFile, (string) $this->moviesCount);
    }
}