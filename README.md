<p align="center">
    <a href="" rel="noopener">
        <img width="700" height="400" src="https://github.com/OUGC-Network/OUGC-Landing-Page/assets/1786584/e05e14b1-f25e-4618-80f1-3d4bb3a0b2d7" alt="Project logo">
    </a>
</p>

<h3 align="center">OUGC Landing Page</h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/OUGC-Network/OUGC-Landing-Page.svg)](./issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/OUGC-Network/OUGC-Landing-Page.svg)](./pulls)
[![License](https://img.shields.io/badge/license-GPL-blue)](/LICENSE)

</div>

---

## 📜 Table of Contents <a name = "table_of_contents"></a>

- [About](#about)
- [Getting Started](#getting_started)
    - [Dependencies](#dependencies)
    - [File Structure](#file_structure)
    - [Install](#install)
    - [Update](#update)
    - [Template Modifications](#template_modifications)
- [Settings](#settings)
- [Usage](#usage)
    - [Force Group Change](#usage_force_group_change)
    - [Redirect to Portal](#usage_redirect_to_portal)
    - [Redirect From Index to Forum](#usage_redirect_index_to_forum)
    - [Redirect to Custom Page](#usage_redirect_ougc_pages)
- [Built Using](#built_using)
- [Authors](#authors)
- [Acknowledgments](#acknowledgement)
- [Support & Feedback](#support)

## 🚀 About <a name = "about"></a>

Introducing OUGC Landing Page by OUGC.Network, a plugin that lets you guide specific user groups to unique pages and
offers the flexibility to skip redirects for chosen bypass scripts. Whether you want to force registration, share
exclusive content, or important updates, this plugin empowers you to create tailored interactions for different users.

[Go up to Table of Contents](#table_of_contents)

## 📍 Getting Started <a name = "getting_started"></a>

The following information will assist you into getting a copy of this plugin up and running on your forum.

### Dependencies <a name = "dependencies"></a>

A setup that meets the following requirements is necessary to use this plugin.

- [MyBB](https://mybb.com/) >= 1.8
- PHP >= 7
- [MyBB-PluginLibrary](https://github.com/frostschutz/MyBB-PluginLibrary) >= 13

### File structure <a name = "file_structure"></a>

  ```
   .
   ├── inc
   │ ├── languages
   │ │ ├── english
   │ │ │ ├── admin
   │ │ │ │ ├── ougcLandingPage.lang.php
   │ │ │ ├── ougcLandingPage.lang.php
   │ ├── plugins
   │ │ ├── ougc
   │ │ │ ├── LandingPage
   │ │ │ │ ├── hooks
   │ │ │ │ │ ├── admin.php
   │ │ │ │ │ ├── forum.php
   │ │ │ │ ├── settings.json
   │ │ │ │ ├── admin.php
   │ │ │ │ ├── core.php
   │ │ ├── ougcLandingPage.php
   ```

### Installing <a name = "install"></a>

Follow the next steps in order to install a copy of this plugin on your forum.

1. Download the latest package from the [MyBB Extend](https://community.mybb.com/mods.php?action=view&pid=1580) site or
   from
   the [repository releases](https://github.com/OUGC-Network/OUGC-Landing-Page/releases/latest).
2. Upload the contents of the _Upload_ folder to your MyBB root directory.
3. Browse to _Configuration » Plugins_ and install this plugin by clicking _Install & Activate_.

### Updating <a name = "update"></a>

Follow the next steps in order to update your copy of this plugin.

1. Browse to _Configuration » Plugins_ and deactivate this plugin by clicking _Deactivate_.
2. Follow step 1 and 2 from the [Install](#install) section.
3. Browse to _Configuration » Plugins_ and activate this plugin by clicking _Activate_.

### Template Modifications <a name = "template_modifications"></a>

This plugin requires no template edits.

[Go up to Table of Contents](#table_of_contents)

## 🛠 Settings <a name = "settings"></a>

Below you can find a description of the plugin settings.

### Global Settings

- **Affected Groups** `select`
    - _Select the groups that will be met with a landing page._
- **Redirect To** `text` Default: `member.php?action=register`
    - _Select the page to where users will be redirected to (land to) relative to the board url._
- **Exempt Scripts** `text`
    - _A JSON list of scripts to bypass when redirecting users. Default:_

```JSON
{
  "captcha.php": "",
  "contact.php": "",
  "member.php": {
    "action": [
      "register",
      "do_register",
      "login",
      "do_login",
      "logout"
    ]
  }
}
```

[Go up to Table of Contents](#table_of_contents)

## 📖 Usage <a name="usage"></a>

This plugin has no additional configurations; after activating make sure to modify the global settings in order to get
this plugin working.

By default, this plugin redirects guest to the registration page, with the freedom to login if already registered.

### Force Group Change <a name="usage_force_group_change"></a>

The following would be the settings necessary to force specific groups to join or leave a group.

- **Redirect To** `text`
    - Value: `usercp.php?action=usergroups`
- **Exempt Scripts** `text`
    - Value:

```JSON
{
  "captcha.php": "",
  "contact.php": "",
  "member.php": {
    "action": [
      "logout"
    ]
  },
  "usercp.php": {
    "action": [
      "usergroups",
      "do_usergroups"
    ]
  }
}
```

### Redirect to Portal <a name="usage_redirect_to_portal"></a>

The following would be the settings necessary to force specific groups to be redirected to the portal.

- **Redirect To** `text`
    - Value: `portal.php`
- **Exempt Scripts** `text`
    - Value:

```JSON
{
  "captcha.php": "",
  "contact.php": "",
  "member.php": {
    "action": [
      "register",
      "do_register",
      "login",
      "do_login",
      "logout"
    ]
  },
  "portal.php": ""
}
```

### Redirect From Index to Forum <a name="usage_redirect_index_to_forum"></a>

The following would be the settings necessary to force specific groups to be redirected from the index page to forum
which forum identifier (`fid`) is `2`.

- **Redirect To** `text`
    - Value: `forumdisplay.php?fid=2`
- **Exempt Scripts** `text`
    - Value:

```JSON
{
  "announcements.php": "",
  "attachment.php": "",
  "calendar.php": "",
  "captcha.php": "",
  "contact.php": "",
  "editpost.php": "",
  "forumdisplay.php": {
    "fid": [
      2
    ]
  },
  "managegroup.php": "",
  "member.php": "",
  "memberlist.php": "",
  "misc.php": "",
  "modcp.php": "",
  "moderation.php": "",
  "newreply.php": "",
  "newthread.php": "",
  "online.php": "",
  "polls.php": "",
  "portal.php": "",
  "printthread.php": "",
  "private.php": "",
  "ratethread.php": "",
  "report.php": "",
  "reputation.php": "",
  "search.php": "",
  "sendthread.php": "",
  "showteam.php": "",
  "showthread.php": "",
  "stats.php": "",
  "syndication.php": "",
  "usercp.php": "",
  "warnings.php": ""
}
```

- **Permanent Redirect** `yesNo`
    - Value: `Yes`

### Redirect to Custom Page <a name="usage_redirect_ougc_pages"></a>

The following would be the settings necessary to force specific groups to be redirected to a custom page using
the [ougc Pages](https://community.mybb.com/mods.php?action=view&pid=6) plugin which page unique url (`url`) is
`unique-url`.

- **Redirect To** `text`
    - Value: `pages.php?page=unique-url`
- **Exempt Scripts** `text`
    - Value:

```JSON
{
  "captcha.php": "",
  "contact.php": "",
  "member.php": {
    "action": [
      "register",
      "do_register",
      "login",
      "do_login",
      "logout"
    ]
  },
  "pages.php": {
    "category": [
      "unique-url"
    ],
    "page": [
      "unique-url"
    ]
  }
}
```

[Go up to Table of Contents](#table_of_contents)

## ⛏ Built Using <a name = "built_using"></a>

- [MyBB](https://mybb.com/) - Web Framework
- [MyBB PluginLibrary](https://github.com/frostschutz/MyBB-PluginLibrary) - A collection of useful functions for MyBB
- [PHP](https://www.php.net/) - Server Environment

[Go up to Table of Contents](#table_of_contents)

## ✍️ Authors <a name = "authors"></a>

- [@Omar G](https://github.com/Sama34) - Idea & Initial work

[Go up to Table of Contents](#table_of_contents)

## 🎉 Acknowledgements <a name = "acknowledgement"></a>

- [The Documentation Compendium](https://github.com/kylelobo/The-Documentation-Compendium)

[Go up to Table of Contents](#table_of_contents)

## 🎈 Support & Feedback <a name="support"></a>

This is free development and any contribution is welcome. Get support or leave feedback at the
official [MyBB Community](https://community.mybb.com/thread-159249.html).

Thanks for downloading and using our plugins!

[Go up to Table of Contents](#table_of_contents)