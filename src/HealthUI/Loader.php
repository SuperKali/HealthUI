<?php

/*
 * HealthUI, a public plugin for PocketMine-MP
 * Copyright (C) 2016-2018 SuperKali
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY;  without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

namespace HealthUI;

use HealthUI\commands\HealthCommand;
use jojoe77777\FormAPI\FormAPI;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as C;

/**
 * Class Loader
 * @package HealthUI
 */
class Loader extends PluginBase implements Listener
{

    /** @var Config $config */
    public $config;

    /** @var FormAPI $form */
    public $form;

    /** @var string PREFIX */
    public const PREFIX = C::BOLD . C::RED . "HealthUI " . C::RESET;

    public function onEnable(): void
    {
        @mkdir($this->getDataFolder());
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, [
            "form" => [
                "title" => "HealthUI",
                "content" => "Write your content!"
            ],
            "permission" => "open.healthgui",
            "no-permission" => "You don't have permission for open this GUI",
            "health" => [
                "Health 5" => 5,
                "Health 10" => 10
            ]
        ]);
        if($this->getServer()->getPluginManager()->getPlugin('FormAPI') == null){
            $this->getServer()->getPluginManager()->disablePlugin($this);
            $this->getLogger()->error(self::PREFIX . "You need FormAPI for enable this plugin, please download FormAPI on poggit");
        }else{
            $this->getLogger()->info(self::PREFIX . "Enabled!");
        }
        $this->form = $this->getServer()->getPluginManager()->getPlugin('FormAPI');
        $this->getServer()->getCommandMap()->register("HealtUI", new HealthCommand("healthui", $this));
    }

    /**
     * @return FormAPI
     */
    public function getForm(): FormAPI
    {
        return $this->form;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }
}
