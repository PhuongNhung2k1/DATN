<?php

namespace AHT\Route\Plugin;

use AHT\Route\Controller\Training\Post;

class TestPlugin1
{

    // khai bao cac function befor, after, arround
    public function beforeTestplugin(Post $subject , $a, $b){
       $a =7;
       $b =8;
       return [$a,$b];
    }

}
