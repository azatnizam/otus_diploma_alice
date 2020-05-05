<?php
namespace Azatnizam;

use Azatnizam\ISkill;
use Azatnizam\BaseSkill;
use Symfony\Component\Yaml\Yaml;
use GuzzleHttp\Client as HttpClient;

class MovieSkill extends BaseSkill
{
    private const SECRET = '14a355e01638761caa047b29b68efb6f';
    private const FAV_MOVIES_COUNT = 5;
    private $mess;
    private $user;

    public function __construct(User $user)
    {
        parent::__construct();

        // localization
        $this->mess = Yaml::parseFile(dirname(__DIR__) . '/lang/skill.yml');
        $this->user = $user;
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
                if ($this->user->getMoviesCount() >= self::FAV_MOVIES_COUNT) {
                    /** Emulator for recommendations */
                    $text = $this->mess['text.recommendation'] . "\n\nFilm\nFilm2\nFilm3";
                    $this
                        ->setButton($this->mess['button.help'])
                        ->setText($text);
                } else {
                    $needFilmsCount = self::FAV_MOVIES_COUNT - $this->user->getMoviesCount();

                    // Message for one or multiple counter
                    if ($needFilmsCount === self::FAV_MOVIES_COUNT) {
                        $text = $this->mess['text.addmorefilm.3'];
                    } elseif ($needFilmsCount === 1) {
                        $text = $this->mess['text.addmorefilm.1'];
                    } else {
                        $text = sprintf($this->mess['text.addmorefilm.2'], $needFilmsCount);
                    }

                    $this
                        ->setButton($this->mess['button.help'])
                        ->setText($text);
                }

                break;

            default:
                $this->user->incrMoviesCount();
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

        if ($apiResponse->status === true) {
            foreach ($apiResponse->movies as $movie) {
                $this->setButton($movie->title);
            }

            if (count($apiResponse->movies) > 0) {
                $this->setText($this->mess['text.choicefilm']);
            } else {
                $this->setText($this->mess['text.filmnotfound']);
            }
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
