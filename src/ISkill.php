<?php
namespace Azatnizam;

/**
 * Interface ISkill
 * Base field for Alice protocol
 */
interface ISkill
{
    public function getSkillResponse();

    public function setButton($value);

    public function setText($value);

    public function setTts($value);

    public function setVersion($value);

    public function setEndSession();
}
