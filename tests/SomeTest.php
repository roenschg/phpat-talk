<?php
namespace ArchitectureTests;

use App\Bar;
use PHPat\Selector\Selector;
use PHPat\Test\Builder\Rule;
use PHPat\Test\PHPat;

class SomeTest
{
    public function test_something(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::classname(\App\Foo::class))
            ->shouldNotDependOn()
            ->classes(Selector::classname(Bar::class))
        ;
    }

    public function controller(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::classname('/App\\(View|Model)\\.*', true))
            ->shouldNotDependOn()
            ->classes(Selector::classname('/App\\Controller\\.*', true))
        ;
    }

    public function views(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::classname('/App\\View\\.*', true))
            ->shouldNotDependOn()
            ->classes(Selector::classname('/App\\Model\\.*', true))
            ;
    }

    public function models(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::classname('/App\\Model\\.*', true))
            ->shouldNotDependOn()
            ->classes(Selector::classname('/App\\View\\.*', true))
            ;
    }

    public function domain(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::namespace('App\Domain'))
            ->shouldNotDependOn()
            ->classes(Selector::all())
            ->excluding(Selector::namespace('App\Domain'))
        ;
    }

    public function commands(): Rule
    {
        return PHPat::rule()
            ->classes(Selector::namespace('App\Command'))
            ->shouldExtend()
            ->classes(Selector::interface(CommandInterface::class))
        ;
    }

    public function only_extend_certain_models(): Rule
    {
        return PHPAt::rule()
            ->classes(Selector::all())
            ->excluding(
                Selector::classname(Very_old_model1::class),
                Selector::classname(Very_old_model2::class),
                Selector::classname(Very_old_model3::class),
            )
            ->shouldNotExtend()
            ->classes(
                Selector::classname(Sql_Model::class),
                Selector::classname(Basic_Config::class),
                Selector::classname(Basic_Model::class),
            )
        ;
    }
}