<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\Entities;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelIdNull;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelInt;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelIntNull;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelString;

class JobEntity extends ContractEntity
{
    private $id;
    private $queue;
    private $payload;
    private $attempts;
    private $reserved_at;
    private $available_at;
    private $created_at;

    public function __construct(
        ContractModelId $id,
        ModelString     $queue,
        ModelString     $payload,
        ModelInt        $attempts,
        ModelIntNull    $reserved_at,
        ModelInt        $available_at,
        ModelString     $created_at
    )
    {
        $this->id           = $id;
        $this->queue        = $queue;
        $this->payload      = $payload;
        $this->attempts     = $attempts;
        $this->reserved_at  = $reserved_at;
        $this->available_at = $available_at;
        $this->created_at   = $created_at;
    }


    /*----------------------------------------------------------------------------------------------------------------*/
    /*---------------------------------------------- Create Functions -----------------------------------------------*/

    /**
     * @param array $data
     * @return static
     */
    protected static function createFromArray(array $data)
    {
        return new static(
            new ModelIdNull($data['id'] ?? null),
            new ModelString($data['queue']),
            new ModelString($data['payload']),
            new ModelInt($data['attempts']),
            new ModelIntNull($data['reserved_at'] ?? null),
            new ModelInt($data['available_at']),
            new ModelString($data['created_at'])
        );
    }

    protected static function createFromObject($item): array
    {
        return [
            'id'            => $item->id,
            'queue'         => $item->queue,
            'payload'       => $item->payload,
            'attempts'      => $item->attempts,
            'reserved_at'   => $item->reserved_at,
            'available_at'  => $item->available_at,
            'created_at'    => $item->created_at,
        ];
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'            => $this->id()->value(),
            'queue'         => $this->queue()->value(),
            'payload'       => $this->payload()->value(),
            'attempts'      => $this->attempts()->value(),
            'reserved_at'   => $this->reserved_at()->value(),
            'available_at'  => $this->available_at()->value(),
            'created_at'    => $this->created_at()->value(),
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

    public function queue(): ModelString
    {
        return $this->queue;
    }

    public function payload(): ModelString
    {
        return $this->payload;
    }

    public function attempts(): ModelInt
    {
        return $this->attempts;
    }

    public function reserved_at(): ModelIntNull
    {
        return $this->reserved_at;
    }

    public function available_at(): ModelInt
    {
        return $this->available_at;
    }

    public function created_at(): ModelString
    {
        return $this->created_at;
    }
}
