<?php
namespace Azatnizam;

use \Azatnizam\AliceRequest;
use \Azatnizam\MovieSkill;

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

        $skill->setButton('Help');

        if ( !is_null( $request->getButtonValue() ) ) {
            $skill
                ->setButton('Clear my history')
                ->setText('Ok. Type film name or part of the name');
        } elseif ( $request->getCommand() ) {
            $skill
                ->setText( 'You command: ' . $request->getCommand() );
        }

        $skill->renderStep();

    }
}