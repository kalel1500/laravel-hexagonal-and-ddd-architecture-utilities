<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\Entities;

use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelBool;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelIdNull;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelString;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\EntityFields\ModelStringNull;

class StateEntity extends ContractEntity
{
    private $id;
    private $name;
    private $finalized;
    private $code;
    private $type;
    private $icon;

    public function __construct(
        ContractModelId $id,
        ModelString $name,
        ModelBool $finalized,
        ModelString $code,
        ModelString $type,
        ModelStringNull $icon
    )
    {
        $this->id   = $id;
        $this->name = $name;
        $this->finalized = $finalized;
        $this->code = $code;
        $this->type = $type;
        $this->icon = $icon;
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
            ModelId::from($data['id'] ?? null),
            new ModelString($data['name']),
            new ModelBool($data['finalized']),
            new ModelString($data['code']),
            new ModelString($data['type']),
            new ModelStringNull($data['icon'])
        );
    }

    protected static function createFromObject($item): array
    {
        return [
            'id'    => $item->id,
            'name'  => $item->name,
            'finalized' => $item->finalized,
            'code' => $item->code,
            'type' => $item->type,
            'icon' => $item->icon,
        ];
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'    => $this->id()->value(),
            'name'  => $this->name()->value(),
            'finalized' => $this->finalized()->value(),
            'code' => $this->code()->value(),
            'type' => $this->type()->value(),
            'icon' => $this->icon()->value(),
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

    public function name(): ModelString
    {
        return $this->name;
    }

    public function finalized(): ModelBool
    {
        return $this->finalized;
    }

    public function code(): ModelString
    {
        return $this->code;
    }

    public function type(): ModelString
    {
        return $this->type;
    }

    public function icon(): ModelStringNull
    {
        return $this->icon;
    }
}
