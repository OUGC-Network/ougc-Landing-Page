<?php

/***************************************************************************
 *
 *    OUGC Landing Page plugin (/inc/plugins/ougcLandingPage/Hooks/forums.php)
 *    Author: Omar Gonzalez
 *    Copyright: © 2021 Omar Gonzalez
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

namespace ougc\LandingPage\Hooks\Forum;

use MyBB;

use function ougc\LandingPage\Core\getSetting;

use const THIS_SCRIPT;

use const TIME_NOW;

function global_start()
{
    global $templatelist, $mybb;

    if (isset($templatelist)) {
        $templatelist .= ',';
    } else {
        $templatelist = '';
    }

    $templatelist .= ',';

    if (!is_member(getSetting('showToGroups'))) {
        return;
    }

    if (defined('THIS_SCRIPT')) {
        $scriptName = my_strtolower(THIS_SCRIPT);
    } else {
        $scriptName = my_strtolower(basename($_SERVER['SCRIPT_NAME']));
    }

    $showLandingPage = true;

    $bypassScripts = (array)json_decode(getSetting('exceptScripts'));

    foreach ($bypassScripts as $fileName => $inputKeys) {
        if ($scriptName === $fileName) {
            if (empty($inputKeys)) {
                $showLandingPage = false;

                break;
            }

            foreach ($inputKeys as $inputKey => $inputValues) {
                if (isset($mybb->input[$inputKey]) && in_array($mybb->get_input($inputKey), $inputValues)) {
                    $showLandingPage = false;

                    break;
                }
            }
        }
    }

    if (!$showLandingPage) {
        return;
    }

    $mybb->settings['redirects'] = $mybb->user['showredirect'] = 0;

    redirect($mybb->settings['bburl'] . '/' . getSetting('redirectPage'));
    //my_setcookie(), my_unsetcookie()
}