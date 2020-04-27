<?php
namespace Azatnizam;

use Azatnizam\ISkill,
    Azatnizam\BaseSkill;

class MovieSkill extends BaseSkill
{
    protected $step;

    protected $message;

    public function getStep(): int
    {

        return 1;
    }

    public function getStepMessage(): string
    {
        return '';
    }

    public function renderStep()
    {
        print $this->getSkillResponse();
    }
}