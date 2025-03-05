<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Services;

final class Renderer
{
    protected const DIST = KALION_PATH.'/public/build/';

    public static function css()
    {
        return '<style>'.file_get_contents(Renderer::DIST.'styles.css').'</style>';
    }

    public static function js()
    {
        return '<script type="module">'.file_get_contents(Renderer::DIST.'scripts.js').'</script>';
    }
}
