<?php

/**
 * Copyright (c) 2020 PJZ9n.
 *
 * This file is part of SimpleShop.
 *
 * SimpleShop is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SimpleShop is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with SimpleShop. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace pjz9n\simpleshop;

use PJZ9n\MoneyConnector\MoneyConnector;
use PJZ9n\MoneyConnector\MoneyConnectorUtils;
use pocketmine\lang\BaseLang;
use pocketmine\plugin\PluginBase;
use RuntimeException;

class Main extends PluginBase
{
    /** @var BaseLang */
    private $lang;

    /** @var MoneyConnector */
    private $money;

    public function onEnable(): void
    {
        $this->saveDefaultConfig();
        $configLang = (string)$this->getConfig()->get("lang", "def");
        $lang = $configLang === "def" ? $this->getServer()->getLanguage()->getLang() : $configLang;
        $localePath = $this->getFile() . "resources/locale/";
        $this->lang = new BaseLang($lang, $localePath, "eng");
        $this->getLogger()->info($this->lang->translateString("language.selected", [$this->lang->getName()]));
        $money = MoneyConnectorUtils::getConnectorByName((string)$this->getConfig()->get("money-api"));
        if (!($money instanceof MoneyConnector)) throw new RuntimeException("Unknown money-api type.");
        $this->money = $money;
    }
}
