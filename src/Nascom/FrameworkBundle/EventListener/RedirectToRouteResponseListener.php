<?php

namespace Nascom\FrameworkBundle\EventListener;

use Nascom\FrameworkBundle\Http\RedirectToRouteResponse;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\Routing\RouterInterface;

class RedirectToRouteResponseListener
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($response instanceof RedirectToRouteResponse) {
            $targetUrl = $this->router->generate($response->getTargetUrl(), $response->getParameters(), RouterInterface::ABSOLUTE_URL);

            if ($fragment = $response->getFragment()) {
                $targetUrl .= '#' . $fragment;
            }

            $response->setTargetUrl($targetUrl);
        }
    }
}
