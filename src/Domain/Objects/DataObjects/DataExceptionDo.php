<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

use Throwable;

final class DataExceptionDo extends ContractDataObject
{
    protected $code;
    protected $success;
    protected $message;
    protected $data;
    protected $exception;
    protected $file;
    protected $line;
    protected $trace;
    protected $previous;

    public function __construct(
        int        $code,
        bool       $success,
        string     $message,
        ?array     $data,
        string     $exception,
        string     $file,
        int        $line,
        array      $trace,
        ?Throwable $previous
    ) {
        $this->code      = $code;
        $this->success   = $success;
        $this->message   = $message;
        $this->data      = $data;
        $this->exception = $exception;
        $this->file      = $file;
        $this->line      = $line;
        $this->trace     = $trace;
        $this->previous  = $previous;
    }

    public function code(): int
    {
        return $this->code;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function message(): string
    {
        return $this->message;
    }

    public function data(): ?array
    {
        return $this->data;
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

    public function toArrayForProd(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'data'    => $this->data,
        ];
    }

    public function toArrayForDebug(): array
    {
        return [
            'success'   => $this->success,
            'message'   => $this->message,
            'data'      => $this->data,
            'exception' => $this->exception,
            'file'      => $this->file,
            'line'      => $this->line,
            'trace'     => $this->trace,
        ];
    }

    public function toArrayWithAll(): array
    {
        return [
            'code'      => $this->code,
            'success'   => $this->success,
            'message'   => $this->message,
            'data'      => $this->data,
            'exception' => $this->exception,
            'file'      => $this->file,
            'line'      => $this->line,
            'trace'     => $this->trace,
            'previous'  => $this->previous,
        ];
    }

    public function toArray(bool $throwInDebugMode = true): array
    {
        return appIsInDebugMode() && $throwInDebugMode ? $this->toArrayForDebug() : $this->toArrayForProd();
    }

}
