<?php

namespace App\Twig;

use Illuminate\Support\Facades\View;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Functions extends AbstractExtension
{
    public function getFunctions()
    {
        return [new TwigFunction('view_blade', [$this, 'view_blade'], ['is_safe' => ['html']])];
    }

    public static function view_blade($path, $data = [])
    {
        return View::make($path, $data)->render();
    }
}