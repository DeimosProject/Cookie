<?php

include_once dirname(__DIR__) . '/vendor/autoload.php';

$builder = new Deimos\Builder\Builder();
$cookie  = new Deimos\Cookie\Cookie($builder, [
    \Deimos\Cookie\Cookie::OPTION_LIFETIME => 3600 * 24 * 7
]);

$cookie->hello = 'hello';

if (!isset($cookie->helloDeimosFlash))
{
    $cookie->flash('hello', 1);

}

$requiredHello = $cookie->getRequired('hello');
$world         = $cookie->get('world', 'мир');

//$cookie->remove('hello');

var_dump($cookie->flash('hello'));
var_dump($requiredHello, $world);

var_dump($cookie);