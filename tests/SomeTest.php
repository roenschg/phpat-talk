<?php
namespace ArchitectureTests;

use App\Bar;
use App\Foo;
use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class SomeTest
{
    public function test_something(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::classname(Foo::class))
            ->shouldNotDependOn()
            ->classes(Selector::classname(Bar::class))
        ;
    }
}