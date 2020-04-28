<?php
namespace Azatnizam;

use Azatnizam\ISkill;

/**
 * Class BaseSkill
 * implements Alice protocol
 */
class BaseSkill implements ISkill
{
    protected $skill_response;

    public function __construct()
    {
        $this->skill_response = new \stdClass();
        $response = new \stdClass();

        $response->text = '';

        // TTS (text-to-speech)
        $response->tts = '';

        $response->buttons = [];

        $response->end_session = false;

        $this->skill_response->response = $response;

        // Alice protocol version
        $this->skill_response->version = '1.0';
    }

    public function getSkillResponse()
    {
        return json_encode($this->skill_response);
    }

    public function setButton($value)
    {
        $button = new \stdClass();
        $button->title = $value;

        $this->skill_response->response->buttons[] = $button;

        return $this;
    }

    public function setText($value)
    {
        $this->skill_response->response->text = $value;

        return $this;
    }

    public function setTts($value)
    {
        $this->skill_response->response->tts = $value;

        return $this;
    }

    public function setVersion($value)
    {
        $this->skill_response->version = $value;

        return $this;
    }

    public function setEndSession()
    {
        $this->skill_response->response->end_session = true;

        return $this;
    }
}