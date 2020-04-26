<?php
namespace Azatnizam;

use Azatnizam\ISkill;

class MovieSkill implements ISkill
{
    protected $response;

    public function __construct()
    {
        $this->response = new \stdClass();
        $this->response->buttons = [];
    }

    public function getResponse()
    {
        return json_encode($this->response);
    }

    public function setButton($value)
    {
        $button = new \stdClass();
        $button->title = $value;

        $this->response->buttons[] = $button;

        return $this;
    }
}