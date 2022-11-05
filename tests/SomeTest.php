<?php

namespace ArchitectureTests;

use App\Bar;
use App\Foo;
use PHPat\Selector\Selector;
use PHPat\Test\PHPat;
use PHPat\Test\Builder\Rule;

class SomeTest
{
    public function test_something(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::classname(Foo::class))
            ->shouldNotExtend()
            ->classes(Selector::classname(Bar::class))
        ;
    }
}