<?php

declare(strict_types=1);

namespace Thehouseofel\Kalion\Domain\Objects\DataObjects\Layout;

use Thehouseofel\Kalion\Domain\Objects\DataObjects\ContractDataObject;
use Thehouseofel\Kalion\Domain\Objects\DataObjects\Layout\Collections\NavbarItemCollection;

final class NavbarDropdownDo extends ContractDataObject
{
    public $is_list;
    public $is_square;
    public $get_data_action;
    public $header;
    public $footer;
    public $items;

    public $userInfo;

    public function __construct(
        ?bool                $is_list,
        ?bool                $is_square,
        ?string              $get_data_action,
        ?string              $header,
        ?NavbarItemDo        $footer,
        NavbarItemCollection $items
    )
    {
        $this->is_list          = $is_list;
        $this->is_square        = $is_square;
        $this->get_data_action  = $get_data_action;
        $this->header           = $header;
        $this->footer           = $footer;
        $this->items            = $items;
    }

    protected static function createFromArray(array $data): self
    {
        return new self(
            $data['is_list'] ?? null,
            $data['is_square'] ?? null,
            $data['get_data_action'] ?? null,
            $data['header'] ?? null,
            NavbarItemDo::fromArray($data['footer'] ?? null),
            NavbarItemCollection::fromArray($data['items'] ?? [])
        );
    }

    public function setItems(NavbarItemCollection $items): void
    {
        $this->items = $items;
    }

    public function setUserInfo(UserInfoDo $userInfo): void
    {
        $this->userInfo = $userInfo;
    }
}
