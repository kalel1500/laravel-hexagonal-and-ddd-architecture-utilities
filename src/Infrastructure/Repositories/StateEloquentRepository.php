<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Infrastructure\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Thehouseofel\Kalion\Domain\Contracts\Repositories\StateRepositoryContract;
use Thehouseofel\Kalion\Domain\Exceptions\Database\RecordNotFoundException;
use Thehouseofel\Kalion\Domain\Objects\Entities\Collections\StateCollection;
use Thehouseofel\Kalion\Domain\Objects\Entities\StateEntity;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Parameters\StatePluckFieldVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Parameters\StatePluckKeyVo;
use Thehouseofel\Kalion\Domain\Objects\ValueObjects\Primitives\EnumDynamicVo;
use Thehouseofel\Kalion\Infrastructure\Models\State;

class StateEloquentRepository implements StateRepositoryContract
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
