<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\DataObjects\Responses;

use Thehouseofel\Kalion\Domain\Objects\DataObjects\ContractDataObject;

abstract class ContractResponseDefaultDo extends ContractDataObject
{
    protected $statusCode;
    protected $success;
    protected $message;
    protected $data;

    /**
     * @param int|null $statusCode
     * @param bool $success
     * @param string|null $message
     * @param array|string|null $data // TODO PHP8 - Union types
     */
    public function __construct(?int $statusCode, bool $success, ?string $message, $data = null)
    {
        $this->statusCode = $statusCode;
        $this->success = $success;
        $this->message = $message;
        $this->data = $data;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success(),
            'message' => $this->message(),
            'data' => $this->data(),
        ];
    }

    public function statusCode(): int
    {
        return $this->statusCode;
    }

    public function success(): bool
    {
        return $this->success;
    }

    public function message(): ?string
    {
        return $this->message;
    }

    public function data()
    {
        return $this->data;
    }
}
