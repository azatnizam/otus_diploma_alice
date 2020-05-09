<?php
namespace Azatnizam;

use Azatnizam\Button;

class AliceRequest
{
    protected $postBody;

    /** @var string defined by yandex protocol */
    protected const BUTTON_TYPE = 'ButtonPressed';

    public function __construct()
    {
        $this->postBody = json_decode( file_get_contents('php://input') );
    }

    /**
     * return yandex user_id (constant for all devices)
     * @return string
     */
    public function getUserId(): string
    {
        return (string) $this->postBody->session->user->user_id;
    }

    /**
     * deprecated
     * @return string
     */
    public function getButtonValue(): string
    {
        return (string) $this->postBody->request->payload->value;
    }

    /**
     * @return \Azatnizam\Button
     */
    public function getButton(): Button
    {
        $button = new Button();
        $button->setValue($this->postBody->request->payload->value);

        return $button;
    }

    public function getRequest()
    {
        if ($this->postBody->request) {
            return $this->postBody;
        }

        return false;
    }

    public function getCommand(): string
    {
        return (string) $this->postBody->request->command;
    }

    public function isButtonPressed(): bool
    {
        if ($this->postBody->request->type == self::BUTTON_TYPE) {
            return true;
        }

        return false;
    }
}