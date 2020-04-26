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

        if ( $request->getRequest() ) {
            print $request->getUserId() . "\n";
            print $request->getButtonValue() . "\n";
//            var_dump( $request->getRequest() );
            $skill->setButton('BTN')->setButton('BTN2');
            print $skill->getResponse();
        } else {
            header('HTTP/1.1 415 Unsupported request data');
        }
    }
}