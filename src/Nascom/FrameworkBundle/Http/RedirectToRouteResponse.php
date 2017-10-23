<?php

namespace Nascom\FrameworkBundle\Http;

use Symfony\Component\HttpFoundation\RedirectResponse;

class RedirectToRouteResponse extends RedirectResponse
{
    private $parameters;
    private $fragment;

    public function __construct($route, array $parameters = [], $fragment = null, $status = 302, $headers = [])
    {
        parent::__construct($route, $status, $headers);

        $this->parameters = $parameters;
        $this->fragment = $fragment;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getFragment()
    {
        return $this->fragment;
    }
}
