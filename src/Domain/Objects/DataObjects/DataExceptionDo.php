<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\DataObjects;

use Throwable;

final class DataExceptionDo extends ContractDataObject
{
    protected $code;
    protected $message;
    protected $data;
    protected $success;
    protected $exception;
    protected $file;
    protected $line;
    protected $trace;
    protected $previous;

    public function __construct(
        int $code,
        string $message,
        array $data,
        bool $success,
        string $exception,
        string $file,
        int $line,
        array $trace,
        ?Throwable $previous
    ) {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
        $this->success = $success;
        $this->exception = $exception;
        $this->file = $file;
        $this->line = $line;
        $this->trace = $trace;
        $this->previous = $previous;
    }

    public function code(): int
    {
        return $this->code;
    }
    public function message(): string
    {
        return $this->message;
    }
    public function data(): array
    {
        return $this->data;
    }
    public function success(): bool
    {
        return $this->success;
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
}
