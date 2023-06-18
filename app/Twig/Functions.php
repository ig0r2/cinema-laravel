<?php

namespace App\Twig;

use Illuminate\Support\Facades\View;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Functions extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('view_blade', [$this, 'view_blade'], ['is_safe' => ['html']]),
            new TwigFunction('is_route', [$this, 'is_route']),
            new TwigFunction('request', [$this, 'request']),
        ];
    }

    public static function view_blade($path, $data = [])
    {
        return View::make($path, $data)->render();
    }

    public static function is_route($route)
    {
        return request()->routeIs($route);
    }

    public static function request($input)
    {
        return request()->input($input);
    }
}
