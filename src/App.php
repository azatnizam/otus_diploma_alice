<?php
namespace Azatnizam;

use \Azatnizam\AliceRequest,
    \Azatnizam\MovieSkill,
    \Symfony\Component\Yaml\Yaml;

class App
{
    public function run()
    {
        $request = new AliceRequest();
        $skill = new MovieSkill();

        if ( !$request->getRequest() ) {
            header('HTTP/1.1 415 Unsupported request data');
            return;
        }

        // localization
//        $mess = Yaml::parseFile(__DIR__ . '/lang/app.yml');
        $mess = $skill->getSkillMessages();


        if ( !is_null( $request->getButtonValue() ) ) {

            $skill->processButton( $request->getButtonValue() );

        } elseif ( $request->getCommand() ) {

            $skill->processCommand( $request->getCommand() );

        } else {

            $skill
                ->setButton($mess['button.help'])
                ->setButton($mess['button.getresult'])
                ->setText($mess['text.welcome']);

        }

        $skill->renderStep();

    }
}