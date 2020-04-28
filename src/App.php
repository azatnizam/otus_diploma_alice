<?php
namespace Azatnizam;

use \Azatnizam\AliceRequest;
use \Azatnizam\MovieSkill;
use \Symfony\Component\Yaml\Yaml;

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
        $mess = Yaml::parseFile(__DIR__ . '/messages.yml');

        $skill->setButton($mess['button.help']);

        if ( !is_null( $request->getButtonValue() ) ) {

            $skill
                ->setButton($mess['button.clear'])
                ->setText($mess['text.addfilm']);

        } elseif ( $request->getCommand() ) {

            $skill->setText( 'You command: ' . $request->getCommand() );

        } else {

            $skill->setText($mess['text.welcome']);

        }

        $skill->renderStep();

    }
}