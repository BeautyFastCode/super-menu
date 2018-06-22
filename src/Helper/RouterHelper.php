<?php

declare(strict_types = 1);

/*
 * (c) BeautyFastCode.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Helper;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * Helper for router, redirect, generate url from route name etc.
 *
 * @author    Bogumił Brzeziński <beautyfastcode@gmail.com>
 * @copyright BeautyFastCode.com
 */
class RouterHelper
{
    /**
     * Interface for the router.
     *
     * @var RouterInterface
     */
    private $router;

    /**
     * Class constructor.
     *
     * @param RouterInterface $router Interface for the router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Returns a RedirectResponse to the given route.
     *
     * @param string $route
     * @param int    $status
     *
     * @return RedirectResponse
     */
    public function redirectToRoute(string $route, int $status = 302): RedirectResponse
    {
        return new RedirectResponse($this->generateURL($route), $status);
    }

    /**
     * Generates a URL from the route name.
     *
     * @param string $route The route name
     *
     * @return string
     */
    public function generateURL(string $route): string
    {
        return $this->router->generate($route);
    }
}
