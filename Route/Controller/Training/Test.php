<?php

namespace AHT\Route\Controller\Training;

class Test
{
    public function execute()
    {
        echo $this->testplugin(5, 6);
    }
    public function testplugin($a, $b)
    {
        $c = $a+$b;
        return $c;
    }
}
