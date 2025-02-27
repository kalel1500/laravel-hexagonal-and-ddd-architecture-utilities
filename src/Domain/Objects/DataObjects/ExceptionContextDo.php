<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Throwable;

final class ExceptionContextDo extends ContractDataObject
{
    protected $statusCode;
    protected $code;
    protected $success;
    protected $message;
    protected $data;
    protected $custom_response;
    protected $exception;
    protected $file;
    protected $line;
    protected $trace;
    protected $previous;

    protected $title;

    public function __construct(
        int        $statusCode,
        string     $message,
        bool       $success,
        ?array     $data,
        ?array     $custom_response,
                   $code,
        string     $exception,
        string     $file,
        int        $line,
        array      $trace,
        ?Throwable $previous
    ) {
        $this->statusCode      = $statusCode;
        $this->message         = $message;
        $this->success         = $success;
        $this->data            = $data;
        $this->custom_response = $custom_response;
        $this->code            = $code;
        $this->exception       = $exception;
        $this->file            = $file;
        $this->line            = $line;
        $this->trace           = $trace;
        $this->previous        = $previous;

        $this->title           = Response::$statusTexts[$this->statusCode];
    }

    /*----------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------- Create Functions -----------------------------------------------*/

    /**
     * @param Throwable $e
     * @param array|null $data
     * @param bool $success
     * @param array|null $custom_response
     * @return ExceptionContextDo
     */
    public static function from(Throwable $e, ?array $data = null, bool $success = false, ?array $custom_response = null): ExceptionContextDo
    {
        // if (is_null($e)) return null; // TODO Canals - pensar

        if (method_exists($e, 'getContext') && !is_null($e->getContext())) return $e->getContext();

        return ExceptionContextDo::fromArray([
            'statusCode'      => (method_exists($e, 'getStatusCode')) ? $e->getStatusCode() : 500,
            'message'         => ExceptionContextDo::getMessage($e),
            'success'         => $success,
            'data'            => $data,
            'custom_response' => $custom_response,
            'code'            => $e->getCode(),
            'exception'       => get_class($e),
            'file'            => $e->getFile(),
            'line'            => $e->getLine(),
            'trace'           => collect($e->getTrace())->map(function ($trace) { return Arr::except($trace, ['args']); })->all(),
            'previous'        => $e->getPrevious()
        ]);
    }

    public static function getMessage(Throwable $e): string
    {
        return (isDomainException($e) || debugIsActive()) ? $e->getMessage() : __('Server Error');
    }

    /*----------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------- toArray Functions -----------------------------------------------*/

    private function toArrayForProd(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data'    => $this->data,
        ];
    }

    private function arrayDebugInfo(): array
    {
        return [
            'exception' => $this->exception,
            'file'      => $this->file,
            'line'      => $this->line,
            'trace'     => $this->trace,
            'previous'  => optional($this->getPreviousData())->toArray(),
        ];
    }

    public function toArrayForBuild(): array
    {
        return [
            'statusCode' => $this->statusCode,
            'message'    => $this->message,
            'success'    => $this->success,
            'data'       => $this->data,
            'code'       => $this->code,
            'exception'  => $this->exception,
            'file'       => $this->file,
            'line'       => $this->line,
            'trace'      => $this->trace,
            'previous'   => $this->previous,
        ];
    }

    public function toArray(bool $throwInDebugMode = true): array
    {
        $addDebugInfo = debugIsActive() && $throwInDebugMode;
        $toArray      = $this->custom_response ?? $this->toArrayForProd();
        return $addDebugInfo ? array_merge($toArray, $this->arrayDebugInfo()) : $toArray;
    }


    /*----------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------------- Properties -------------------------------------------------*/

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function data(): ?array
    {
        return $this->data;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function exception(): string
    {
        return $this->exception;
    }

    public function file(): string
    {
        return $this->file;
    }

    public function line(): int
    {
        return $this->line;
    }

    public function trace(): array
    {
        return $this->trace;
    }

    public function previous(): ?Throwable
    {
        return $this->previous;
    }

    public function getPreviousData(): ?ExceptionContextDo
    {
        return is_null($this->previous) ? null : ExceptionContextDo::from($this->previous);
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /*public function getLastPrevious(): ?Throwable
    {
        $exception = $this->previous; // Empieza desde la propiedad $previous

        // Itera sobre las excepciones previas
        while ($exception && $exception->getPrevious()) {
            $exception = $exception->getPrevious();
        }

        // Retorna la excepción más interna o null si no hay más
        return $exception;
    }*/
}
