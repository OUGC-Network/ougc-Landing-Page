<?php

/***************************************************************************
 *
 *    OUGC Landing Page plugin (/inc/languages/english/admin/ougcLandingPage.lang.php)
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

$l = [
    'ougcLandingPage' => 'OUGC Landing Page',
    'ougcLandingPageDescription' => 'Set a forced landing page for certain groups.',

    'setting_group_ougcLandingPage' => 'Landing Page',
    'setting_group_ougcLandingPage_desc' => 'Set a forced landing page for certain groups.',

    'setting_ougcLandingPage_showToGroups' => 'Affected Groups',
    'setting_ougcLandingPage_showToGroups_desc' => 'Select the groups that will be met with a landing page.',
    'setting_ougcLandingPage_redirectPage' => 'Redirect To',
    'setting_ougcLandingPage_redirectPage_desc' => 'Select the page to where users will be redirected to. If not a valid full url, it must be relative to the board url without trailing slash. Default: <code>member.php?action=register</code>',
    'setting_ougcLandingPage_exceptScripts' => 'Exempt Scripts',
    'setting_ougcLandingPage_exceptScripts_desc' => 'A JSON list of scripts to bypass when redirecting users. Default: <pre>
{
  "captcha.php": "",
  "contact.php": "",
  "css.php": "",
  "member.php": {
    "action": [
      "register",
      "do_register",
      "login",
      "do_login",
      "logout"
    ]
},
  "task.php": "",
  "xmlhttp.php": ""
}
</pre><br/>Use online tools like <a href="https://jsonformatter.curiousconcept.com/" target="_blank" rel="noopener noreferrer">JSON Formatter & Validator</a> to help you format your JSON correctly.',
    'setting_ougcLandingPage_permanentRedirect' => 'Permanent Redirect',
    'setting_ougcLandingPage_permanentRedirect_desc' => 'Whether to use a permanent redirect (301).',

    'ougcLandingPagePluginLibrary' => 'This plugin requires <a href="{1}">PluginLibrary</a> version {2} or later to be uploaded to your forum.',
];