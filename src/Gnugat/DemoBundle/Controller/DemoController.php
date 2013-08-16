<?php

namespace Gnugat\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;

class DemoController extends Controller
{
    public function helloWorldAction()
    {
        return new Response('<html><body>Hello world!</body></html>');
    }
}
