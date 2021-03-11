<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function sort()
    {
        $stack1 = [9,3,0,6,5,11,-1,10,4,8,1,-3,7,2];
        $stack2 = [];

        do {
            $minTemp = array_pop($stack1);

            for($j=count($stack2)-1;$j>=0;$j--)
                if($minTemp < $stack2[$j])
                    array_push($stack1,array_pop($stack2));

            array_push($stack2,$minTemp);
        } while (count($stack1) > 0);

        return $stack2;
    }
}
