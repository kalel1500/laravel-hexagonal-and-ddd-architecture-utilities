<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Entities;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelIdNull;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;

class FailedJobEntity extends ContractEntity
{
    private $id;
    private $uuid;
    private $connection;
    private $queue;
    private $payload;
    private $exception;
    private $failed_at;

    public function __construct(
        ContractModelId $id,
        ModelString     $uuid,
        ModelString     $connection,
        ModelString     $queue,
        ModelString     $payload,
        ModelString     $exception,
        ModelString     $failed_at
    )
    {
        $this->id           = $id;
        $this->uuid         = $uuid;
        $this->connection   = $connection;
        $this->queue        = $queue;
        $this->payload      = $payload;
        $this->exception    = $exception;
        $this->failed_at    = $failed_at;
    }


    /*----------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------- Create Functions -----------------------------------------------*/

    protected static function createFromArray(array $data): self
    {
        return new self(
            new ModelIdNull($data['id'] ?? null),
            new ModelString($data['uuid']),
            new ModelString($data['connection']),
            new ModelString($data['queue']),
            new ModelString($data['payload']),
            new ModelString($data['exception']),
            new ModelString($data['failed_at'])
        );
    }

    protected static function createFromObject($item): array
    {
        return [
            'id'            => $item->id,
            'uuid'          => $item->uuid,
            'connection'    => $item->attributesToArray()['connection'],
            'queue'         => $item->queue,
            'payload'       => $item->payload,
            'exception'     => $item->exception,
            'failed_at'     => $item->failed_at,
        ];
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'            => $this->id()->value(),
            'uuid'          => $this->uuid()->value(),
            'connection'    => $this->connection()->value(),
            'queue'         => $this->queue()->value(),
            'payload'       => $this->payload()->value(),
            'exception'     => $this->exception()->value(),
            'failed_at'     => $this->failed_at()->value(),
        ];
    }


    /*----------------------------------------------------------------------------------------------------------------*/
    /*--------------------------------------------------- Relaciones -------------------------------------------------*/


    /*----------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------------- Campos BD -------------------------------------------------*/

    /**
     * @return ContractModelId|ModelId|ModelIdNull // TODO PHP8 - Union types
     */
    public function id() // TODO PHP8 - Union types -> ModelId|ModelIdNull
    {
        return $this->id;
    }

    public function uuid(): ModelString
    {
        return $this->uuid;
    }

    public function connection(): ModelString
    {
        return $this->connection;
    }

    public function queue(): ModelString
    {
        return $this->queue;
    }

    public function payload(): ModelString
    {
        return $this->payload;
    }

    public function exception(): ModelString
    {
        return $this->exception;
    }

    public function failed_at(): ModelString
    {
        return $this->failed_at;
    }
}
