<?php
namespace Azatnizam;

use Azatnizam\Button;

/**
 * Interface ISkill
 * Base field for Alice protocol
 */
interface ISkill
{
    public function getSkillResponse();

    public function setButton(Button $button);

    public function setText($value);

    public function setTts($value);

    public function setVersion($value);

    public function setEndSession();
}
