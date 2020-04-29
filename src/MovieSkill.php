<?php
namespace Azatnizam;

use Azatnizam\ISkill,
    Azatnizam\BaseSkill,
    \Symfony\Component\Yaml\Yaml;

class MovieSkill extends BaseSkill
{
    protected $step;

    protected $mess;

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
                $this
                    ->setButton('Film https://www.kinopoisk.ru/film/326/')
                    ->setButton('Film2 https://www.kinopoisk.ru/film/435/')
                    ->setButton('Film3 https://www.kinopoisk.ru/film/326/')
                    ->setText($this->mess['text.recommendation']);
                break;

            default:
                /** Emulator for film add */
                $this
                    ->setButton($this->mess['button.help'])
                    ->setText('Film has been successfully added');
                break;

        }

    }

    public function processCommand(string $command)
    {
        /** Emulator for film list */
        $this
            ->setButton('Film #1')
            ->setButton('Film #2')
            ->setButton('Film #3')
            ->setText($this->mess['text.choicefilm']);
    }

    public function renderStep()
    {
        print $this->getSkillResponse();
    }
}
