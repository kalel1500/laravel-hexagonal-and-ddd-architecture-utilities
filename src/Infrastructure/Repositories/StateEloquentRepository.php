<?php

declare(strict_types=1);

namespace Thehouseofel\Hexagonal\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Thehouseofel\Hexagonal\Domain\Contracts\Repositories\StateRepositoryContract;
use Thehouseofel\Hexagonal\Domain\Exceptions\Database\RecordNotFoundException;
use Thehouseofel\Hexagonal\Domain\Objects\Collections\StateCollection;
use Thehouseofel\Hexagonal\Domain\Objects\Entities\StateEntity;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters\StatePluckFieldVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Parameters\StatePluckKeyVo;
use Thehouseofel\Hexagonal\Domain\Objects\ValueObjects\Primitives\EnumDynamicVo;
use Thehouseofel\Hexagonal\Infrastructure\Models\State;

final class StateEloquentRepository implements StateRepositoryContract
{
    private $eloquentModel;

    public function __construct()
    {
        $this->eloquentModel = new State();
    }

    public function all(): StateCollection
    {
        $eloquentResult = $this->eloquentModel->newQuery()->get();
        return StateCollection::fromEloquent($eloquentResult);
    }

    public function getDictionary(?StatePluckFieldVo $field, ?StatePluckKeyVo $key): array
    {
        $field  = $field ?? StatePluckFieldVo::id(); // TODO PHP8 - in parameter -> StatePluckFieldVo $field = new StatePluckFieldVo(StatePluckFieldVo::id)
        $key    = $key ?? StatePluckKeyVo::code(); // TODO PHP8 - in parameter -> StatePluckKeyVo $key = new StatePluckKeyVo(StatePluckKeyVo::code)
        return $this->all()->pluck($field->value(), $key->value())->toArray();
    }

    public function getDictionaryByType(EnumDynamicVo $type, ?StatePluckFieldVo $field, ?StatePluckKeyVo $key): array
    {
        $field  = $field ?? StatePluckFieldVo::id(); // TODO PHP8 - in parameter -> StatePluckFieldVo $field = new StatePluckFieldVo(StatePluckFieldVo::id)
        $key    = $key ?? StatePluckKeyVo::code(); // TODO PHP8 - in parameter -> StatePluckKeyVo $key = new StatePluckKeyVo(StatePluckKeyVo::code)
        return $this->getByType($type)->pluck($field->value(), $key->value())->toArray();
    }

    public function getByType(EnumDynamicVo $type): StateCollection
    {
        $eloquentResult = $this->eloquentModel
            ->newQuery()
            ->where('type', $type->value())
            ->get();

        return StateCollection::fromEloquent($eloquentResult);
    }

    public function findByCode(EnumDynamicVo $code): StateEntity
    {
        try {
            $eloquentResult = $this->eloquentModel
                ->newQuery()
                ->where('code', $code->value())
                ->firstOrFail();
            return StateEntity::fromArray($eloquentResult->toArray());
        } catch (ModelNotFoundException $e) {
            throw new RecordNotFoundException($e->getMessage());
        }
    }
}
