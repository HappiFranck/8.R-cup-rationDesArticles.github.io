<?php

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\RouterTwigExtension;
use Framework\Twig\{
    PagerFantaExtension, TextExtension, TimeExtension
};

return [
    'database.host' => 'localhost',
    'database.username' => 'admin',
    'database.password' => 'admin',
    'database.name' => 'poo',
    'views.path' => dirname(__DIR__) . '/views',
    //On injecte les classes d'extension définit
    'twig.extensions' => [
      \DI\get(RouterTwigExtension::class),
      \DI\get(PagerFantaExtension::class),
      //On injecte la classe TextExtension
      \DI\get(TextExtension::class),
      \DI\get(TimeExtension::class)
    ],
    \Framework\Router::class => \DI\object(),
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    \PDO::class => function (\Psr\Container\ContainerInterface $c) {
        return new PDO(
            'mysql:host=' . $c->get('database.host') . ';dbname=' . $c->get('database.name'),
            $c->get('database.username'),
            $c->get('database.password'),
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
];