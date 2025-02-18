<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Domain\Objects\Entities;

use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\Contracts\ContractModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelId;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelString;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\EntityFields\ModelStringNull;

class UserEntity extends ContractEntity
{
    public ContractModelId $id;
    public ModelString     $name;
    public ModelString     $email;
    public ModelStringNull $email_verified_at;

    public function __construct(
        ContractModelId $id,
        ModelString     $name,
        ModelString     $email,
        ModelStringNull $email_verified_at
    )
    {
        $this->id                = $id;
        $this->name              = $name;
        $this->email             = $email;
        $this->email_verified_at = $email_verified_at;
    }

    /**
     * @param array $data
     * @return static
     */
    protected static function createFromArray(array $data)
    {
        return new static(
            ModelId::from($data['id']),
            ModelString::new($data['name']),
            ModelString::new($data['email']),
            ModelStringNull::new($data['email_verified_at']),
        );
    }

    /**
     * @param array $data
     * @param array $newFields
     * @return static
     */
    protected static function createFromChildArray(array $data, array $newFields)
    {
        return new static(
            ModelId::from($data['id']),
            ModelString::new($data['name']),
            ModelString::new($data['email']),
            ModelStringNull::new($data['email_verified_at']),
            ...$newFields
        );
    }

    protected function toArrayProperties(): array
    {
        return [
            'id'                => $this->id->value(),
            'content'           => $this->name->value(),
            'email'             => $this->email->value(),
            'email_verified_at' => $this->email_verified_at->value(),
        ];
    }
}
