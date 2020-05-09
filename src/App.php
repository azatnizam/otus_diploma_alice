<?php
namespace Azatnizam;

use Azatnizam\AliceRequest;
use Azatnizam\MovieSkill;
use Azatnizam\Button;
use Symfony\Component\Yaml\Yaml;

class App
{
    public function run()
    {
        $request = new AliceRequest();
        $user = new User($request->getUserId());
        $skill = new MovieSkill($user);

        if (!$request->getRequest()) {
            header('HTTP/1.1 415 Unsupported request data');
            return;
        }


        if ($request->isButtonPressed()) {
            $skill->processButton($request->getButton());
        } elseif ($request->getCommand()) {
            $skill->processCommand($request->getCommand());
        } else {
            $skill->processWelcome();
        }

        $skill->renderStep();
    }
}