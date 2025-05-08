<?php

/*
 * @copyright Copyright 2003-202025 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version v2.0.0 $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$autoLoadConfig[0][] = [
    'autoType' => 'class',
    'loadFile' => 'observers/auto.attrib_image_swap.php'
];

$autoLoadConfig[199][] = [
    'autoType' => 'classInstantiate',
    'className' => 'zcObserverAttribImageSwap',
    'objectName' => 'zcObserverAttribImageSwap'
];

