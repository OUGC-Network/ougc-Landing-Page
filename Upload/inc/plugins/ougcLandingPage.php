<?php

/***************************************************************************
 *
 *    OUGC Landing Page plugin (/inc/plugins/ougcLandingPage.php)
 *    Author: Omar Gonzalez
 *    Copyright: © 2023 Omar Gonzalez
 *
 *    Website: https://ougc.network
 *
 *    Set a forced landing page for certain groups.
 *
 ***************************************************************************
 ****************************************************************************
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 ****************************************************************************/

declare(strict_types=1);

use function ougc\LandingPage\Admin\pluginInfo;

use function ougc\LandingPage\Admin\pluginActivate;

use function ougc\LandingPage\Admin\pluginDeactivate;

use function ougc\LandingPage\Admin\pluginInstall;

use function ougc\LandingPage\Admin\pluginIsInstalled;

use function ougc\LandingPage\Admin\pluginUninstall;

use function ougc\LandingPage\Core\addHooks;

use function ougc\LandingPage\Core\loadLanguage;

// Die if IN_MYBB is not defined, for security reasons.
defined('IN_MYBB') || die('This file cannot be accessed directly.');

// You can uncomment the lines below to avoid storing some settings in the DB
define('ougc\LandingPage\Core\SETTINGS', [
    //'key' => '',
    'exceptScriptsExtra' => [
        'member.php' => [
            'action' => [
                'register',
                'do_register',
                'login',
                'do_login'
            ]
        ]
    ]
]);

const OUGCLANDINGPAGE_ROOT = \MYBB_ROOT . 'inc/plugins/ougc/LandingPage';

require_once OUGCLANDINGPAGE_ROOT . '/core.php';

// PLUGINLIBRARY
defined('PLUGINLIBRARY') || define('PLUGINLIBRARY', \MYBB_ROOT . 'inc/plugins/pluginlibrary.php');

if (defined('IN_ADMINCP')) {
    require_once OUGCLANDINGPAGE_ROOT . '/admin.php';

    require_once OUGCLANDINGPAGE_ROOT . '/hooks/admin.php';

    addHooks('ougc\LandingPage\Hooks\Admin');
} else {
    require_once OUGCLANDINGPAGE_ROOT . '/hooks/forum.php';

    addHooks('ougc\LandingPage\Hooks\Forum');
}

function ougcLandingPage_info(): array
{
    return pluginInfo();
}

function ougcLandingPage_activate()
{
    pluginActivate();
}

function ougcLandingPage_deactivate()
{
    pluginDeactivate();
}

function ougcLandingPage_install()
{
    pluginInstall();
}

function ougcLandingPage_is_installed(): bool
{
    return pluginIsInstalled();
}

function ougcLandingPage_uninstall()
{
    pluginUninstall();
}