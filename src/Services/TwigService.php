<?php

namespace JamesMiranda\Services;

use Twig_Environment;
use Twig_Loader_Filesystem;

/**
 * Class TwigService
 * @author James Miranda <james.miranda@riosoft.com>
 * @package JamesMiranda\Services
 */
class TwigService
{
    protected $loader;

    protected $twig;

    /**
     * TwigService constructor.
     */
    public function __construct()
    {
        $this->loader = new Twig_Loader_Filesystem (
            __DIR__ . '/../Views/'
        );

        $this->twig = new Twig_Environment($this->loader, [
            'cache' => '/tmp/twigCache',
            'auto_reload' => true
        ]);
        $this->twig->addFunction(new \Twig_SimpleFunction('js', function ($asset) {
            return sprintf('/../Views/js/%s', ltrim($asset, '/'));
        }));
    }

    /**
     * @return Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }
}