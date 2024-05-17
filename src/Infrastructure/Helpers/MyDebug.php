<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Helpers;

use Illuminate\Support\Facades\DB;
use Thehouseofel\Hexagonal\Domain\Traits\Singelton;

final class MyDebug
{
    use Singelton;

    public function start()
    {
        DB::enableQueryLog();
    }

    public function show()
    {
        dd(DB::getQueryLog());
    }

}
