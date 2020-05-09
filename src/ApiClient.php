<?php
namespace Azatnizam;

use Azatnizam\Movie;
use Azatnizam\User;
use GuzzleHttp\Client as HttpClient;
use DS\Vector;

final class ApiClient
{
    private const SECRET = '14a355e01638761caa047b29b68efb6f';
    private const BASE_URI = 'https://lyagusha.com';
    private const LIST_URL = '/movies/list/';
    private const POST_PREFERENCE = '/movies/preference';
    private $httpClient;
    private $status;
    private $url;

    public function __construct()
    {
        $this->httpClient = new HttpClient([
            'base_uri' => self::BASE_URI
        ]);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $command
     * @return Vector list of type Movie;
     */
    public function getList(string $command): Vector
    {
        $this->status = false;
        $list = new Vector();

        $this->prepare(self::LIST_URL . $command);
        $apiResponse = json_decode($this->httpClient->get($this->url)->getBody());

        $this->status = $apiResponse->status;
        foreach ($apiResponse->movies as $responseMovie) {
            $movie = new Movie();
            $movie
                ->setId($responseMovie->id)
                ->setTitle($responseMovie->title)
                ->setPopularity($responseMovie->populariry);

            $list->push($movie);
        }

        return $list;
    }

    /**
     * @param User $user
     * @param Movie $movie
     * @return Vector list of saved movies (type Movie) for this user
     */
    public function postPreference(User $user, Movie $movie): Vector
    {
        $this->status = false;
        $list = new Vector();

        $this->prepare(self::POST_PREFERENCE);
        $postBody = new \stdClass();
        $postBody->user_id = $user->getId();
        $postBody->movies = [$movie->getId()];
        $apiResponse = json_decode($this->httpClient->post($this->url, ['body' => json_encode($postBody)])->getBody());

        $this->status = $apiResponse->status;
        foreach ($apiResponse->movies as $responseMovie) {
            $movie = new Movie();
            $movie->setId($responseMovie);

            $list->push($movie);
        }

        return $list;
    }

    /**
     * @param string $url
     */
    private function prepare(string $url): void
    {
        $expires = time();
        $sign = hash_hmac('sha256', $expires, self::SECRET);
        $this->url = $url . '?' . http_build_query(['expires' => $expires, 'sign' => $sign]);
    }

}