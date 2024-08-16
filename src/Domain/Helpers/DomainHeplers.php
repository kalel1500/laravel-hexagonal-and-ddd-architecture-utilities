<?php

declare(strict_types=1);

use Illuminate\Support\Arr;
use Thehouseofel\Hexagonal\Domain\Exceptions\CustomException;
use Thehouseofel\Hexagonal\Domain\Exceptions\InvalidValueException;
use Thehouseofel\Hexagonal\Domain\Exceptions\RequiredDefinitionException;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\CollectionAny;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts\ContractCollectionAny;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\Contracts\ContractCollectionEntity;
use Thehouseofel\Hexagonal\Domain\Objects\DataObjects\DataExceptionDo;
use Thehouseofel\Hexagonal\Infrastructure\Exceptions\DomainBaseException;

if (!function_exists('dashesToCamelCase')) {
    function dashesToCamelCase($string, $capitalizeFirstCharacter = false)
    {

        $str = str_replace('-', '', ucwords($string, '-'));

        if (!$capitalizeFirstCharacter) {
            $str = lcfirst($str);
        }

        return $str;
    }
}

if (!function_exists('strToCamelCase')) {
    function strToCamelCase(?string $string): ?string
    {
        if (is_null($string)) return null;
        $string = remove_accents($string);
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9_\- ]/i', ' ', $string);
        $intermediate = str_replace(['_', ' ', '/', '-'], '', ucwords($string, '_ '));

        // $intermediate = preg_replace_callback(
        //     '/(?:^|_| )(\w)/',
        //     function ($matches) {
        //         return strtoupper($matches[1]);
        //     },
        //     $string
        // );

        return lcfirst($intermediate);
    }
}
if (!function_exists('remove_accents')) {
    function remove_accents($cadena){
        $cadena = mb_convert_encoding($cadena, 'UTF-8');

		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);

		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );

		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );

		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );

		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );

		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);

		return $cadena;
	}
}
if (!function_exists('getFirstMessageIfIsArray')) {
    function getFirstMessageIfIsArray($message)
    {
        if (!is_array($message)) {
            return $message;
        } else {
            return $message[0];
        }
    }
}

if (!function_exists('stringHtmlOfArrayMessages')) {
    function stringHtmlOfArrayMessages($arrayMessages, $messagesClass = 'restriction-message'): string
    {
        if (!is_array($arrayMessages)) {
            return '<span class="' . $messagesClass . '">' . $arrayMessages . '</span><br>';
        }

        $htmlMessages = '<div class="d-block">';
        foreach ($arrayMessages as $message) {
            $htmlMessages .= '<span class="' . $messagesClass . '">' . $message . '</span><br>';
        }
        $htmlMessages .= '</div>';

        return $htmlMessages;
    }
}

if (!function_exists('strContains')) {
    function strContains($haystack, $needle): bool
    {
        return strpos($haystack, $needle) !== false;
    }
}

if (!function_exists('arrayContains')) {
    function arrayContains($array, $key, $value): bool
    {
        $result = array_search($value, array_column($array, $key));
        return !(($result === false));
    }
}

if (!function_exists('arrayFirstWhere')) {
    function arrayFirstWhere($array, $key, $value)
    {
        $result = array_search($value, array_column($array, $key));
        return $array[$result];
    }
}

if (!function_exists('clearArrayToIntegers')) {
    function clearArrayToIntegers($arrayToClear): array
    {
        $result = [];
        foreach ($arrayToClear as $item) {
            $int_item = intval($item);
            if ($int_item) {
                $result[] = $int_item;
            }
        }
        return $result;
    }
}

if (!function_exists('arrayToString')) {
    function arrayToString(array $array): ?string
    {
        if (empty($array)) {
            return null;
        }
        return implode(", ", $array);
    }
}

if (!function_exists('strTurncate')) {
    function strTurncate(string $string, int $length = 100, string $append = '&hellip;'): ?string
    {
        // Check append length
        if ($length <= strlen($append)) {
            return null;
        }

        // Srting min length
        if (strlen($string) <= $length) {
            return $string;
        }

        // Truncate code

        $length = $length - strlen($append);
        $string = trim($string);

        // Version 1 (este código no corta palabras por la mitad)
//        $string = wordwrap($string, $length);
//        $string = explode("\n", $string, 2);
//        $string = $string[0] . $append;

        // Version 2
        return substr($string, 0, $length) . $append;
    }
}

if (!function_exists('anyToBoolean')) {
    function anyToBoolean($value): bool
    {
        return $value === 'true' || $value === true || $value === 1 || $value === '1';
    }
}

if (!function_exists('strStartsWith')) {
    function strStartsWith($haystack, $needle, $case = true): bool
    {
        if ($case) {
            return strpos($haystack, $needle) === 0;
        }
        return stripos($haystack, $needle) === 0;
    }
}

if (!function_exists('strEndsWith')) {
    function strEndsWith($haystack, $needle, $case = true): bool
    {
        $expectedPosition = strlen($haystack) - strlen($needle);
        if ($case) {
            return strrpos($haystack, $needle) === $expectedPosition;
        }
        return strripos($haystack, $needle) === $expectedPosition;
    }
}

if (!function_exists('verifyEmail')) {
    function verifyEmail($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL));
    }
}

if (!function_exists('splitAtUpperCase')) {
    function splitAtUpperCase($s)
    {
        return preg_split('/(?=[A-Z])/', $s, -1, PREG_SPLIT_NO_EMPTY);
    }
}

if (!function_exists('arrayHasDupes')) {
    function arrayHasDupes($array): bool
    {
        return count($array) !== count(array_unique($array));
    }

}

if (!function_exists('buildForeignKeyName')) {
    function buildForeignKeyName($tableName, $columnName): string
    {
        return $tableName . '_' . $columnName . '_foreign';
    }
}

if (!function_exists('addMessagesSeparator')) {
    function addMessagesSeparator(array $arrayOfMessages, string $separator = '||'): ?string
    {

        $finalMessage = '';
        foreach ($arrayOfMessages as $key => $message) {
            if (!empty($message)) {
                $finalMessage .= $message;
            }

            $nextKey = $key + 1;
            $nextMessage = $arrayOfMessages[$nextKey] ?? null;
            if (!empty($nextMessage)) {
                $finalMessage .= $separator;
            }
        }
        return empty($finalMessage) ? null : $finalMessage;
    }
}

if (!function_exists('abortC')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param int $code
     * @param string $message
     * @param array|null $data
     * @param bool $success
     * @param Throwable|null $previous
     * @return void
     */
    function abortC(
        int $code,
        string $message,
        ?array $data = null,
        bool $success = false,
        ?Throwable $previous = null
    ): void
    {
        throw new CustomException($message, $code, $data, $success, $previous);
    }
}

if (!function_exists('abortC_if')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param bool $condition
     * @param int $code
     * @param string $message
     * @param array|null $data
     * @param bool $success
     * @param Throwable|null $previous
     * @return void
     */
    function abortC_if(
        bool $condition,
        int $code,
        string $message,
        ?array $data = null,
        bool $success = false,
        ?Throwable $previous = null
    ): void
    {
        if ($condition) {
            abortC($code, $message, $data, $success, $previous);
        }
    }
}

if (!function_exists('getExceptionData')) {
    function getExceptionData(Throwable $e, ?array $data = null, bool $success = false): DataExceptionDo
    {
        if (isDomainException($e) && isset($e->exceptionData)) {
            return $e->exceptionData;
        }

        $code = $e->getCode();
        $code = ($code === 0 && $e instanceof \Symfony\Component\HttpKernel\Exception\HttpException) ? $e->getStatusCode() : $code;
        $code = (!is_int($code)) ? 500 : $code;
        $code = ($code === 0) ? 500 : $code;
        $trace = collect($e->getTrace())->map(function ($trace) {
            return Arr::except($trace, ['args']);
        })->all();
        return new DataExceptionDo(
            $code,
            $success,
            getExceptionMessage($e),
            $data,
            get_class($e),
            $e->getFile(),
            $e->getLine(),
            $trace,
            $e->getPrevious()
        );
    }
}

if (!function_exists('isValidBoolean')) {
    function isValidBoolean($value): bool
    {
        return (is_bool($value) || (($value === 0 || $value === 1)));
    }
}

/*if (!function_exists('collectInts')) {
    function collectInts(array $numbers)
    {
        $res = [];
        foreach ($numbers as $number) {
            $res[] = new IntVo((int)$number);
        }
        return new CollectionIntsVo(...$res);
    }
}*/

/*if (!function_exists('collectArrayTo')) {
    function collectArrayTo(array $values, $valueClass, $collectionClass, callable $valueModifierCallback = null)
    {
        $res = [];
        foreach ($values as $value) {
            if (!is_null($valueModifierCallback)) {
                $value = $valueModifierCallback($value);
            }
            $res[] = new $valueClass($value);
        }
        return new $collectionClass(...$res);
    }
}*/

if (!function_exists('isDomainException')) {
    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param Throwable $e
     * @return bool
     */
    function isDomainException(Throwable $e): bool
    {
//        return (($e instanceof \DomainException) || ($e instanceof CustomException));
        return (($e instanceof DomainBaseException));
    }
}

if (!function_exists('getSrcNamespace')) {
    function getSrcNamespace(): string
    {
        return 'Src\\';
    }
}

if (!function_exists('getRelationCollection')) {
    function getRelationCollection(array $value, string $collectionClass)
    {
        $isCollection = is_subclass_of($collectionClass, ContractCollectionEntity::class);
        if (!$isCollection) {
            throw new InvalidValueException(sprintf('The <%s> variable must be extends of <%s>.', '$collectionClass', class_basename(ContractCollectionEntity::class)));
        }
        $entityClass = $collectionClass::ENTITY;
        $existEntity = !is_null($entityClass);
        if (!$existEntity) {
            throw new RequiredDefinitionException(sprintf('<%s> needs to define <%s> %s.', $collectionClass, 'ENTITY', 'constant'));
        }

        $array = [];
        foreach ($value as $item) {
            $array[] = $entityClass::fromArray($item);
        }
        return new $collectionClass(...$array);
    }
}

if (!function_exists('collectAny')) {
    function collectAny(array $array): CollectionAny
    {
        return CollectionAny::fromArray($array);
    }
}

if (!function_exists('objectToArray')) {
    function objectToArray($object)  // TODO PHP8 - Union types (array|object)
    {
        $string = json_encode($object);
        return json_decode($string, true);
    }
}

if (!function_exists('arrayToObject')) {
    function arrayToObject($object)  // TODO PHP8 - Union types (array|object)
    {
        $string = json_encode($object);
        return json_decode($string);
    }
}

if (!function_exists('stringToArray')) {
    function stringToArray(string $stringJson)
    {
        return json_decode($stringJson, true);
    }
}

if (!function_exists('stringToObject')) {
    function stringToObject(string $stringJson)
    {
        return json_decode($stringJson);
    }
}

if (!function_exists('cloneObject')) {
    function cloneObject($object)
    {
        return unserialize(serialize($object));
    }
}

if (!function_exists('arrayKeepKeys')) {
    function arrayKeepKeys($arrayData, $arrayKeys): array
    {
        $new = [];
        foreach ($arrayData as $key => $item) {
            if (in_array($key, $arrayKeys)) {
                $new[$key] = $item;
            }
        }
        return $new;
    }
}

if (!function_exists('arrayDeleteKeys')) {
    function arrayDeleteKeys($arrayData, $arrayKeys): array
    {
        $new = [];
        foreach ($arrayData as $key => $item) {
            if (!in_array($key, $arrayKeys)) {
                $new[$key] = $item;
            }
        }
        return $new;
    }
}

if (!function_exists('array_diff_assoc_recursive')) {
    function array_diff_assoc_recursive(array $array1, array $array2): array {
        $difference = array();
        foreach($array1 as $key => $value) {
            if( is_array($value) ) {
                if( !isset($array2[$key]) || !is_array($array2[$key]) ) {
                    $difference[$key] = $value;
                } else {
                    $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                    if(!empty($new_diff)) {
                        $difference[$key] = $new_diff;
                    }
                }
            } else if( !array_key_exists($key,$array2) || $array2[$key] !== $value ) {
                $difference[$key] = $value;
            }

            /*if (
                (!is_array($value) && (!array_key_exists($key, $array2) || $array2[$key] !== $value))
                ||
                (is_array($value) && (!isset($array2[$key]) || !is_array($array2[$key])))
            ) {
                $difference[$key] = $value;
                continue;
            }

            if (is_array($value) && (isset($array2[$key]) && is_array($array2[$key]))) {
                $new_diff = array_diff_assoc_recursive($value, $array2[$key]);
                if(!empty($new_diff)) {
                    $difference[$key] = $new_diff;
                }
            }*/
        }
        return $difference;
    }

}

if (!function_exists('array_unshift_assoc')) {
    function array_unshift_assoc($arr, $key, $val): array
    {
        $arr = array_reverse($arr, true);
        $arr[$key] = $val;
        return array_reverse($arr, true);
    }
}

if (!function_exists('isBlank')) {
    function isBlank($value): bool
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (!function_exists('getExceptionMessage')) {
    function getExceptionMessage(Throwable $e): string
    {
        return (isDomainException($e) || appIsInDebugMode())
            ? $e->getMessage()
            : __('serverError');
    }
}

if (!function_exists('clearWith')) {
    function clearWith(?array $with, ?array $allowedRels): ?array
    {
        if (is_null($with) || is_null($allowedRels)) return null;
        $newWith = [];
        foreach ($with as $key => $rel) {
            $compareRel = (is_array($rel)) ? $key : $rel;
            $arrayRels = explode('.', $compareRel);
            $firstRel = $arrayRels[0];
            if (in_array($firstRel, $allowedRels)) {
                $newWith[$key] = $rel;
            }
        }
        return (empty($newWith)) ? null : $newWith;
    }
}

if (!function_exists('getSubWith')) {
    function getSubWith(?array $with, ?string $relationName): ?array
    {
        if (is_null($with)) return null;
        if (is_null($relationName)) return $with;
        $newWith = [];
        foreach ($with as $key => $rel) {
            $compareKey = is_array($rel);
            if ($compareKey && $key === $relationName) {
                $newWith = $rel;
                break;
            }
            if (!$compareKey) {
                $arrayRels = explode('.', $rel);
                $firstRel = $arrayRels[0];
                if ($firstRel === $relationName) {
                    unset($arrayRels[0]);
                    $newWith = implode('.', $arrayRels);
                    break;
                }
            }
        }
        return (empty($newWith)) ? null : (is_array($newWith) ? $newWith : [$newWith]);
    }
}

if (!function_exists('mapToLabelStructure')) {
    function mapToLabelStructure($labelField, $valueField): Closure
    {
        return function ($item) use ($labelField, $valueField) { return ['label' => $item->$labelField, 'value' => $item->$valueField]; };
        // TODO PHP8 - return fn($item) => ['label' => $item->$labelField, 'value' => $item->$valueField];
    }
}

if (!function_exists('soIsWindows')) {
    function soIsWindows(): bool
    {
        $so = strtoupper(substr(PHP_OS, 0,3));
        return $so === 'WIN';
    }
}
