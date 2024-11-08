
# Formatear los logs como JSON
```php

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AnyApiProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for('startAsyncAction', function (Request $request) {
            return Limit::perMinute(1)->by($request->path());
            // return $request->is('*/status/*') ? Limit::perMinute(1)->by($request->path()) : Limit::none();
        });
    }
}
```