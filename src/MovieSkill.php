<?php
namespace Azatnizam;

use Azatnizam\ISkill;
use Azatnizam\BaseSkill;
use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\Client as HttpClient;

class MovieSkill extends BaseSkill
{
    private $step;

    private $mess;

    private const SECRET = '14a355e01638761caa047b29b68efb6f';

    public function __construct()
    {
        parent::__construct();

        // localization
        $this->mess = Yaml::parseFile(__DIR__ . '/lang/skill.yml');
    }


    public function getSkillMessages(): array
    {
        return $this->mess;
    }

    public function processButton(string $button)
    {
        switch ($button) {

            case $this->mess['button.help']:
                $this
                    ->setButton($this->mess['button.getresult'])
                    ->setText($this->mess['text.help']);
                break;

            case $this->mess['button.getresult']:
                /** Emulator for recommendations */
                $text = $this->mess['text.recommendation'] . "\n\nFilm https://www.kinopoisk.ru/film/326/ \nFilm2 https://www.kinopoisk.ru/film/435/\nFilm3 https://www.kinopoisk.ru/film/326/";
                $this
                    ->setButton($this->mess['button.help'])
                    ->setText($text);
                break;

            default:
                /** Emulator for film add */
                $this
                    ->setButton($this->mess['button.getresult'])
                    ->setButton($this->mess['button.help'])
                    ->setText($this->mess['text.filmadded']);
                break;

        }

    }

    public function processCommand(string $command)
    {
        // TODO: move base_uri to config
        $http = new HttpClient(['base_uri' => 'https://lyagusha.com']);

        $expires = time();
        $sign = hash_hmac('sha256', $expires, self::SECRET);
        $url = '/movies/list/' . $command . '?' . http_build_query(['expires' => $expires, 'sign' => $sign]);

        $apiResponse = json_decode($http->get($url)->getBody());
        if ($apiResponse->status === 'true') {
            foreach ($apiResponse->movies as $movie) {
                $this->setButton($movie->title);
            }

            $this->setText($this->mess['text.choicefilm']);
        } else {
            $this
                ->setButton($this->mess['button.help'])
                ->setText($this->mess['text.error.getlist']);
        }
    }

    public function renderStep()
    {
        print $this->getSkillResponse();
    }
}
