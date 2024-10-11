<?php

declare(strict_types=1);

use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Collection as CollectionE;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\ExceptionContextDo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters\EnvVo;
use Thehouseofel\Hexagonal\Infrastructure\Helpers\MyCarbon;

if (!function_exists('showActiveClass')) {
    function showActiveClass(string $value, ?string $paramName = null, ?string $paramValue = null): bool
    {
        $routeName = Route::currentRouteName();
        $param = Route::current()->parameters[$paramName] ?? null;
        if (is_null($paramName)) {
            return ($routeName === $value);
        } elseif (is_null($paramValue)) {
            return ($routeName === $value && !isset($param));
        } else {
            return ($routeName === $value && isset($param) && $param === $paramValue);
        }
    }
}

if (!function_exists('getRouteInput')) {
    function getRouteInput($value)
    {
        return Route::current()->parameter($value) ?? null;
    }
}

if (!function_exists('routeContains')) {
    function routeContains($wordToSearch): bool
    {
        $routeName = Route::currentRouteName();
        return strpos($routeName, $wordToSearch) !== false;
    }
}

if (!function_exists('createRandomString')) {
    function createRandomString($minNumberChars, $maxNumberChars): string
    {
        $faker = Faker::create();
        $positionsInWhichAddSpaces = [5, 10, 15, 20, 25, 30, 35, 40, 45];
        $numberChars = $faker->numberBetween($minNumberChars, $maxNumberChars);
        $string = '';
        for ($i=0; $i<=$numberChars; $i++) {
            $string .= (in_array($i, $positionsInWhichAddSpaces)) ? ' ' : $faker->randomLetter;
        }
        return $string;
    }
}

/*if (!function_exists('checkObjectProperties')) {
    function checkObjectProperties($object, $arrayProperties, $preventException = false)
    {
        $checkProperties = collect([]);
        foreach ($arrayProperties as $prop) {
            $checkProperties->push(property_exists($object, $prop));
        }

        if ($checkProperties->contains(false)) {
            if ($preventException) return false;
            throw new \Exception(__('The object does not meet the required properties'));
        }

        return true;
    }
}*/

if (!function_exists('formatStringDatetimeTo')) {
    function formatStringDatetimeTo($datetime, $format = 'Y-m-d\TH:i'): ?string
    {
        return MyCarbon::stringToformat($datetime, $format);
    }
}

if (!function_exists('compareDates')) {
    function compareDates($date1, $operator, $date2)
    {
        return MyCarbon::compare($date1, $operator, $date2);
    }
}

//if (!function_exists('upsert_getArraysForExcept')) {
//    /**
//     * @param array $arrayData
//     * @param array $arrayKeys
//     * @param array $exceptColumns
//     * @param bool $deleteTimestamps
//     * @return MyUpsert
//     */
//    function upsert_getArraysForExcept($arrayData, $arrayKeys, $exceptColumns, $deleteTimestamps = true)
//    {
//        $upsert = new MyUpsert($arrayData, $arrayKeys, $exceptColumns, $deleteTimestamps);
//        return $upsert;
//
//        /*$arrayUpdate = array_diff(array_keys($arrayData[0]), $exceptColumns);
//        return [
//            'arrayData' => $arrayData,
//            'arrayKeys' => $arrayKeys,
//            'arrayUpdate' => $arrayUpdate,
//        ];*/
//    }
//}

//if (!function_exists('upsert_ExecuteForExcept')) {
//    /**
//     * @param Builder $builder
//     * @param $arrayData
//     * @param $arrayKeys
//     * @param $exceptColumns
//     * @param bool $deleteTimestamps
//     */
//    function upsert_executeForExcept(Builder $builder, $arrayData, $arrayKeys, $exceptColumns, $deleteTimestamps = true)
//    {
//        $upsert = new MyUpsert($arrayData, $arrayKeys, $exceptColumns, $deleteTimestamps);
//        $upsert->executeUpsert($builder);
//    }
//}

if (! function_exists('collectE')) {
    /**
     * Create a collection from the given value.
     *
     * @param mixed $value
     * @return CollectionE
     */
    function collectE($value = null)
    {
        return new CollectionE($value);
    }
}

if (! function_exists('collectionContains')) {
    function collectionContains(Collection $collection, $keySearch, $valueSearch): bool
    {
        $filtered = $collection->filter(function ($value, $key) use ($keySearch, $valueSearch) {
//        return strtolower($value->$keySearch) == strtolower($valueSearch);
            return stristr(strtolower($value->$keySearch), strtolower($valueSearch)) == true;
        });
        return $filtered->isNotEmpty();
    }
}

if (! function_exists('myCarbon')) {
    function myCarbon(): MyCarbon
    {
        return new MyCarbon();
    }
}

if (! function_exists('getEnvironment')) {
    function getEnvironment(): string
    {
        $env = new EnvVo(config('app.env'));
        return $env->value();
    }
}

if (! function_exists('getEnvironmentReal')) {
    function getEnvironmentReal(): ?string
    {
        return config('hexagonal.real_env_in_tests');
    }
}

if (! function_exists('envIsPorduction')) {
    function envIsPorduction(): bool
    {
        return getEnvironment() === EnvVo::production;
    }
}

if (! function_exists('envIsPre')) {
    function envIsPre(): bool
    {
        return getEnvironment() === EnvVo::preproduction;
    }
}

if (! function_exists('envIsLocal')) {
    function envIsLocal(): bool
    {
        return getEnvironment() === EnvVo::local;
    }
}

if (! function_exists('envIsNotPorduction')) {
    function envIsNotPorduction(): bool
    {
        return !envIsPorduction();
    }
}

if (! function_exists('envIsNotPre')) {
    function envIsNotPre(): bool
    {
        return !envIsPre();
    }
}

if (! function_exists('envIsNotLocal')) {
    function envIsNotLocal(): bool
    {
        return !envIsLocal();
    }
}

if (! function_exists('envIsTest')) {
    function envIsTest(): bool
    {
        return config('app.env') === EnvVo::testing;
    }
}

if (! function_exists('appIsInDebugMode')) {
    function appIsInDebugMode(): bool {
        return config('app.debug');
    }
}

if (! function_exists('formatArrayOfEmailsToSendMail')) {
    function formatArrayOfEmailsToSendMail($array): array
    {
        return collect($array)
            ->map(function ($value) {return (verifyEmail($value)) ? ['name' => null, 'email' => $value] : null;})
            ->filter(function ($value) {return !is_null($value);})
            ->all();
    }
}

if (! function_exists('getGoodEmailsFromArray')) {
    function getGoodEmailsFromArray($array): array
    {
        if (is_string($array)) {
            $array = explode(',', $array);
        }
        return collect($array)
            ->map(function ($value) {return trim($value);})
            ->filter(function ($value) {return verifyEmail($value);})
            ->all();
    }
}

if (!function_exists('isValidationException')) {
    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param Throwable $e
     * @return bool
     */
    function isValidationException(Throwable $e): bool
    {
        return ($e instanceof ValidationException);
    }
}

if (!function_exists('urlContainsAjax')) {
    function urlContainsAjax(): bool
    {
        return (str_contains(URL::current(), '/ajax/'));
    }
}

if (! function_exists('responseJson')) {
    /**
     * @param bool $success
     * @param string $message
     * @param mixed $data
     * @param int $responseCode
     * @return JsonResponse
     */
    function responseJson(bool $success, string $message, $data = null, int $responseCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data
        ], $responseCode);
    }
}

if (! function_exists('responseJsonWith')) {
    function responseJsonWith(array $data = [], int $responseCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json($data, $responseCode);
    }
}

if (! function_exists('responseJsonError')) {
    /**
     * @param Throwable $e
     * @param bool $success
     * @param string|null $message
     * @param array $data
     * @param bool $throwInDebugMode
     * @return JsonResponse
     * @throws Throwable
     */
    function responseJsonError(Throwable $e, bool $throwInDebugMode = true): JsonResponse
    {
        // INFO kalel1500 - mi_estructura_de_respuesta
        $exceptionData = ExceptionContextDo::from($e);
        return response()->json($exceptionData->toArray($throwInDebugMode), $exceptionData->getStatusCode());
    }
}

if (!function_exists('myOptional')) {
    function myOptional($value)
    {
        return optional($value);
    }
}

if (! function_exists('src_path')) {
    /**
     * Get the path to the application folder.
     *
     * @return string
     */
    function src_path(): string
    {
        return base_path().DIRECTORY_SEPARATOR.'src';
    }
}

if (!function_exists('dbTransaction')) {
    function dbTransaction($callback)
    {
        DB::transaction($callback);
    }
}

if (!function_exists('strToSnake')) {
    function strToSnake($str): string
    {
        return Str::snake($str);
    }
}

if (!function_exists('arrSort')) {
    function arrSort($array, $callback): array
    {
        return Arr::sort($array, $callback);
    }
}

if (!function_exists('myCollect')) {
    function myCollect(array $array)
    {
        return collect($array);
    }
}

if (!function_exists('collFirst')) {
    function collFirst(array $array, callable $callback = null, $default = null)
    {
        return collect($array)->first($callback, $default);
    }
}

if (!function_exists('collLast')) {
    function collLast(array $array, callable $callback = null, $default = null)
    {
        return collect($array)->last($callback, $default);
    }
}

if (!function_exists('collWhere')) {
    function collWhere(array $array, $key, $operator = null, $value = null)
    {
        if (func_num_args() === 2) {
            $value = true;
            $operator = '=';
        }
        if (func_num_args() === 3) {
            $value = $operator;
            $operator = '=';
        }
        return collect($array)->where($key, $operator, $value);
    }
}

if (!function_exists('collWhereIn')) {
    function collWhereIn(array $array, $key, $values, $strict = false)
    {
        return collect($array)->whereIn($key, $values, $strict);
    }
}

if (!function_exists('collContains')) {
    function collContains(array $array, $key, $operator = null, $value = null): bool
    {
        $coll = collect($array);
        if (func_num_args() === 2) {
            return $coll->contains($key);
        }
        if (func_num_args() === 3) {
            return $coll->contains($key, $operator);
        }
        return $coll->contains($key, $operator, $value);
    }
}

if (!function_exists('collUnique')) {
    function collUnique(array $array, $key = null, $strict = false)
    {
        return collect($array)->unique($key, $strict);
    }
}

if (!function_exists('collFilter')) {
    function collFilter(array $array, callable $callback = null)
    {
        return collect($array)->filter($callback);
    }
}

if (!function_exists('collSortBy')) {
    function collSortBy(array $array, $callback, $options = SORT_REGULAR, $descending = false)
    {
        return collect($array)->sortBy($callback, $options, $descending);
    }
}

if (!function_exists('collSort')) {
    function collSort(array $array, $callback = null)
    {
        return collect($array)->sort($callback);
    }
}

if (!function_exists('collSortDesc')) {
    function collSortDesc(array $array, $options = SORT_REGULAR)
    {
        return collect($array)->sortDesc($options);
    }
}

if (!function_exists('collGroupBy')) {
    function collGroupBy(array $array, $groupBy, $preserveKeys = false)
    {
        return collect($array)->groupBy($groupBy, $preserveKeys);
    }
}

if (!function_exists('collSelect')) {
    function collSelect(array $array, $keys)
    {
//        $keys = is_array($keys) ? $keys : func_get_args();
        return collect($array)->map(function ($item) use ($keys) {
            return collect($item)->only($keys)->toArray();
        });
    }
}

if (!function_exists('collFlatten')) {
    function collFlatten(array $array, $depth = INF)
    {
        return collect($array)->flatten($depth);
    }
}

if (!function_exists('collTake')) {
    function collTake(array $array, int $limit)
    {
        return collect($array)->take($limit);
    }
}

if (!function_exists('arrAllValuesAreArray')) {
    function arrAllValuesAreArray(array $array)
    {
        $filtered = Arr::where($array, function ($value, $key) {
            return !is_array($value);
        });
        return (count($filtered) === 0);
    }
}

if (! function_exists('broadcastingIsActive')) {
    function broadcastingIsActive(): bool
    {
        return (bool)config('hexagonal.broadcasting_enabled');
    }
}

//if (!function_exists('formatToTabulatorList')) {
//    /**
//     * @param Collection|ContractCollectionBase $collection // TODO PHP8 - Union types
//     * @return Collection|ContractCollectionBase // TODO PHP8 - Union types
//     */
//    function formatToTabulatorList($collection, string $value, string $key, bool $toLabel = false)
//    {
//        if ($toLabel) {
//            return $collection->map(mapToLabelStructure($value, $key));
//        }
//        return $collection->pluck($value, $key)->prepend('', 'undefined')->prepend('', 'null')->prepend('', '');
//    }
//}




if (!function_exists('HTTP_NA')) {
    function HTTP_NA(): int
    {
        return 500;
    }
}

if (!function_exists('HTTP_OK')) {
    function HTTP_OK(): int
    {
        return Response::HTTP_OK;
    }
}

if (!function_exists('HTTP_BAD_REQUEST')) {
    function HTTP_BAD_REQUEST(): int
    {
        return Response::HTTP_BAD_REQUEST;
    }
}

if (!function_exists('HTTP_CONFLICT')) {
    function HTTP_CONFLICT(): int
    {
        return Response::HTTP_CONFLICT;
    }
}

if (!function_exists('HTTP_UNAUTHORIZED')) {
    function HTTP_UNAUTHORIZED(): int
    {
        return Response::HTTP_UNAUTHORIZED;
    }
}

if (!function_exists('HTTP_NOT_FOUND')) {
    function HTTP_NOT_FOUND(): int
    {
        return Response::HTTP_NOT_FOUND;
    }
}

if (!function_exists('HTTP_INTERNAL_SERVER_ERROR')) {
    function HTTP_INTERNAL_SERVER_ERROR(): int
    {
        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}

