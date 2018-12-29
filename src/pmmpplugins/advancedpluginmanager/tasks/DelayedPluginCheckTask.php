<?php

namespace pmmpplugins\advancedpluginmanager\tasks;

use pmmpplugins\advancedpluginmanager\api\API;
use pmmpplugins\advancedpluginmanager\AdvancedPluginManager;
use pocketmine\scheduler\Task;

/**
 * Author: pmmp-plugins
 * Project: AdvancedPluginManager
 * File: DelayedPluginCheckTask.php
 * Date: 18.12.18
 * IDE: PhpStorm
 */
class DelayedPluginCheckTask extends Task
{
    private $pluginManager;

    public function __construct(AdvancedPluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }

    public function onRun(int $tick): void
    {
        API::filterPluginsStartup($this->pluginManager);
    }
}