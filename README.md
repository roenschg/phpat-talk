# PHPat - Define your application architecture by writing tests

by Ralf Junghans and Gerd Rönsch

__Proudly made with Marp__

---

# Introduction

IMG of me

- Developing with PHP since 2006
- Works currently at Digistore24 GmbH
- Loves Codeing-Rules and Static Code Analasis

---

# Architecture Testing Tool Landscape

- Deptrac
- PHPat
- https://github.com/VKCOM/nocolor

---

# PHPat vs Deptrac

## PHPat

- ✅ Simple to read (Uses PHP-Code with Explicit Definition)
- ✅ Can be faster
- ❌ No visualisation
- ❌ Still a BETA

## Deptrac

- ✅ Stable code base with big community
- ✅ Has visualization
- ❌ Uses YAML and is hard to read
- ❌ Can get slow on bigger projects

---

# PHPAt vs NoColor

---

# Honorable Mentions

- https://github.com/phparkitect/arkitect
- https://github.com/j6s/phparch

---

# Installation

```shell
composer require --dev phpstan/phpstan phpat/phpat
```

```yaml
# phpstan.neon
parameters:
  level: 1
  paths:
    - tests
    - src

includes:
  - vendor/phpat/phpat/extension.neon

services:
  - class: ArchitectureTests\SomeTest
    tags:
      - phpat.test
```

---

# The Building Blocks

**Selectors** -- Which classes / traits / enums to test against

**Assertions** -- Definition of boundaries and requirements

---

```php
# Class reference
Selector::classname(Foo::class);

# String class reference
Selector::classname('Foo\Bar');

# Regex
Selector::classname('/[A-Z][a-z]{2}\\Bar/', true);
```

---

```php
Selector::classname()

Selector::namespace()

Selector::interface()
```

```php
Selector::abstract()
Selector::final()

Selector::implements()
Selector::extends()

Selector::enum()
```

```php
Selector::all()
```

---

# Assertions

```php
# Inheritance
$selection->shouldExtend()
$selection->shouldNotExtend()
```

```php
# Interfaces
$selection->shouldImplement()
$selection->shouldNotImplement()
```

```php
# Construction
$selection->shouldNotConstruct()
```

---

```php
$selection->shouldNotDependOn()
```

```php
class Foo extends Bar
{
    private Bar $bar;
    private Bar $bar2;

    public function __construct(Bar $bar)
    {
        $this->bar2 = new Bar();
    }
}
```

---

# Example Test

```php
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
```

---

```php
class Foo extends Bar
{
    private Bar $bar;
    private Bar $bar2;

    public function __construct(Bar $bar)
    {
        $this->bar2 = new Bar();
    }
}
```

![](failure.png)

----

# Use-Cases

---

# Vendors coupling / Cage the domain logic

```php
public function domain(): Rule
{
    return PHPat::rule()
        ->classes(Selector::namespace('App\Domain'))
        ->shouldNotDependOn()
        ->classes(Selector::all())
        ->excluding(Selector::namespace('App\Domain'))
    ;
}
```

---

# Reserving a Namespace for Commands

```php
public function commands(): Rule
{
    return PHPat::rule()
        ->classes(Selector::namespace('App\Command'))
        ->shouldExtend()
        ->classes(Selector::interface(CommandInterface::class))
    ;
}
```

___

# MVC

```php
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
```

---

# The Legacy Models

![height:600px](ci_models.png)

---

```php
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
```

---