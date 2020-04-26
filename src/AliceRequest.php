<?php
namespace Azatnizam;

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

    public function getButtonValue()
    {
        if ( $this->isButtonPressed() ) {
            return $this->getCommand();
        }

        return null;
    }

    public function getRequest()
    {
        if ($this->postBody->request) {
            return $this->postBody;
        }

        return false;
    }

    protected function getCommand()
    {
        return $this->postBody->request->command;
    }

    protected function isButtonPressed(): bool
    {
        if ($this->postBody->request->type == self::BUTTON_TYPE) {
            return true;
        }

        return false;
    }
}