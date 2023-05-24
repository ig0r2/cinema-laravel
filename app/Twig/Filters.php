<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class Filters extends AbstractExtension
{
    public function getFilters()
    {
        return [new TwigFilter('day_name', [$this, 'day_name'])];
    }

    public static function day_name($day)
    {
        switch ($day) {
            case 1:
                return 'Ponedeljak';
            case 2:
                return 'Utorak';
            case 3:
                return 'Sreda';
            case 4:
                return 'Četvrtak';
            case 5:
                return 'Petak';
            case 6:
                return 'Subota';
            default:
                return 'Nedelja';
        }
    }
}
