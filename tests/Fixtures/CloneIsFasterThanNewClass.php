<?php
/**
 * (c) Artem Ostretsov <artem@ostretsov.ru>
 * Created at 28.09.17 6:56.
 */

namespace Tests\Fixtures;

class CloneIsFasterThanNewClass
{
    private $a;
    private $b;
    private $c;

    public function __construct()
    {
        $this->a = 1;
        $this->b = 2;
        $this->c = 3;
    }
}