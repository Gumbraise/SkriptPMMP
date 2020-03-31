<?php

namespace skript\Metrics;

use poketmine\PoketMine;
use poketmine\plugin\Plugin;
use poketmine\utils\UUID;

$charts = array();

class Metrics {
    public static $B_STATS_VERSION = 1;

    private static $URL = "https://bStats.org/submitData/bukkit";

    private static $logFailedRequests;

    private static $serverUUID;

    public function Metrics($plugin) {
        if ($plugin == NULL) {
            throw new IllegalArgumentException("Plugin cannot be null!");
        }
        $this->plugin = $plugin;

        $bStatsFolder = "../bStats";
        $configFile = \file_get_contents($bStatsFolder.'config.yml');
        $config = yaml_parse($configFile);

        if (!isset($config['serverUuid'])) {
            $config['enabled'] = true;

            $UUID = new UUID();
            $config['serverUuid'] = $UUID->fromRandom.$UUID->toString;

            $config['logFailedRequests'] = false;
        }

        $serverUUID = $config['serverUUID'];
        $logFailedRequests = $config['logFailedRequests'] = false;

        if ($config['enabled'] == true) {
            $found = true;

            if (!$found) {
                startSubmitting();
            }
        }
    }

    public function addCustomChart($chart) {
        if ($chart == NULL) {
            throw new IllegalArgumentException("Chart cannot be null!");
        }

        array_push($charts, $chart);
    }

    private function startSubmitting() {
        $timer = time();

        new TimerTask();
    }

    public function run() {
        submitData();
    }
}