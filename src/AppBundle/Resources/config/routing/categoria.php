<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('categoria_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Categoria:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('categoria_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Categoria:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('categoria_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Categoria:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('categoria_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Categoria:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('categoria_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Categoria:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
