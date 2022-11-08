<?php

namespace App;

class Foo extends Bar
{
    private Bar $bar;
    private Bar $bar2;

    public function __construct(Bar $bar)
    {
        $this->bar2 = new Bar();
    }
}