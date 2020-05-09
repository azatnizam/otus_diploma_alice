<?php
namespace Azatnizam;

use Azatnizam\BaseSkill;
use Azatnizam\Button;
use Symfony\Component\Yaml\Yaml;

class MovieSkill extends BaseSkill
{
    // TODO: delete from this file
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

    public function processButton(Button $button)
    {
        switch ($button->getValue()) {

            case $this->mess['button.help']:
                $this
                    ->setButton(
                        (new Button())
                            ->setTitle($this->mess['button.getresult'])
                            ->setValue($this->mess['button.getresult'])
                    )
                    ->setText($this->mess['text.help']);
                break;

            case $this->mess['button.getresult']:
                if ($this->user->getMoviesCount() >= self::FAV_MOVIES_COUNT) {

                    /** Emulator for recommendations */
//                    $text = $this->mess['text.recommendation'] . "\n\nFilm\nFilm2\nFilm3";
//                    $this
//                        ->setButton($this->mess['button.help'])
//                        ->setText($text);
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
                        ->setButton(
                            (new Button())
                                ->setTitle($this->mess['button.help'])
                                ->setValue($this->mess['button.help'])
                        )
                        ->setText($text);
                }

                break;

            default:
                $movieId = (int) $button->getValue();
                $api = new ApiClient();
                $movies = $api->postPreference($this->user, (new Movie())->setId($movieId));

                if ($movies->isEmpty() !== true) {
                    $this->user->setMoviesCount(count($movies));
                }

                $this
                    ->setButton(
                        (new Button())
                            ->setTitle($this->mess['button.getresult'])
                            ->setValue($this->mess['button.getresult'])
                    )
                    ->setButton(
                        (new Button())
                            ->setTitle($this->mess['button.help'])
                            ->setValue($this->mess['button.help'])
                    );

                if ($api->getStatus() === true) {
                    $this->setText($this->mess['text.filmadded']);
                } else {
                    $this->setText($this->mess['text.error.add']);
                }

                break;
        }

    }

    public function processCommand(string $command)
    {
        $api = new ApiClient();
        $movies = $api->getList($command);

        if ($api->getStatus() === true) {
            foreach ($movies as $movie) {
                $this->setButton(
                    (new Button())
                        ->setTitle($movie->getTitle())
                        ->setValue($movie->getId())
                );
            }

            if (count($movies) > 0) {
                $this->setText($this->mess['text.choicefilm']);
            } else {
                $this->setText($this->mess['text.filmnotfound']);
            }
        } else {
            $this
                ->setButton(
                    (new Button())
                        ->setTitle($this->mess['button.help'])
                        ->setValue($this->mess['button.help'])
                )
                ->setText($this->mess['text.error.getlist']);
        }
    }

    public function renderStep()
    {
        print $this->getSkillResponse();
    }
}
