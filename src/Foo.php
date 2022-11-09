<?php

namespace App;

class Foo extends Bar
{
    private Bar $bar;

    public function __construct(Bar $bar)
    {
        $this->bar = new Bar();
    }
}