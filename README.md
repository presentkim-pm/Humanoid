[![Telegram](https://img.shields.io/badge/Telegram-PresentKim-blue.svg?logo=telegram)](https://t.me/PresentKim)

[![License](https://img.shields.io/github/license/PMMPPlugin/Humanoid.svg?label=License)](LICENSE)
[![Poggit](https://poggit.pmmp.io/ci.shield/PMMPPlugin/Humanoid/Humanoid)](https://poggit.pmmp.io/ci/PMMPPlugin/Humanoid)
[![Release](https://img.shields.io/github/release/PMMPPlugin/Humanoid.svg?label=Release)](https://github.com/PMMPPlugin/Humanoid/releases/latest)
[![Download](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/total.svg?label=Download)](https://github.com/PMMPPlugin/Humanoid/releases/latest)


A plugin give virtual chest to player for PocketMine-MP

## Command
Main command : `/humanoid <add | set | remove | copy | cancel | lang | reload | save>`

| subcommand | arguments              | description                 |
| ---------- | ---------------------- | --------------------------- |
| Add        | \[name\]               | Add humanoid                |
| Set        | \<data name\> \[data\] | Change humanoid's data      |
| Remove     |                        | Remove humanoid             |
| Copy       |                        | Copy humanoid               |
| Cancel     |                        | Cancel act                  |
| Lang       | \<language prefix\>    | Load default lang file      |
| Reload     |                        | Reload all data             |
| Save       |                        | Save all data               |




## Permission
| permission          | default  | description        |
| ------------------- | -------- | ------------------ |
| humanoid.cmd        | OP       | main command       |
|                     |          |                    |
| humanoid.cmd.add    | OP       | add subcommand     |
| humanoid.cmd.set    | OP       | set  subcommand    |
| humanoid.cmd.remove | OP       | remove subcommand  |
| humanoid.cmd.copy   | OP       | copy subcommand    |
| humanoid.cmd.cancel | OP       | cancel subcommand  |
| humanoid.cmd.lang   | OP       | lang subcommand    |
| humanoid.cmd.reload | OP       | reload subcommand  |
| humanoid.cmd.save   | OP       | save subcommand    |




## \<data name\> list
ex)  `/humanoid Set List 2`

| name       | arguments                        | description                     |
| ---------- | -------------------------------- | ------------------------------- |
| List       | \[page\]                         | Show data name list             |
| Name       | \[name\]                         | Change humanoid's name          |
| Rotation   | * or \<yaw\> \<pitch\>           | Change humanoid's yaw and pitch |
| Item       | * or \<item id\> \[item meta\]   | Change humanoid's held item     |
| Skin       | * or \<player name\>             | Change humanoid's skin          |
| Geometry   | \<geometry name\>                | Change humanoid's geometry name |
| Sneak      |                                  | Toggle humanoid's sneaking      |
| Position   | * or \<player name\> or \<x\> \<y\> \<z\> \[world name\] | Change humanoid's position |
| Scale      | \<scale percent\>                | Change humanoid's scale         |




## ChangeLog
### v1.0.0 [![Source](https://img.shields.io/badge/source-v1.0.0-blue.png?label=source)](https://github.com/PMMPPlugin/Humanoid/tree/v1.0.0) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/v1.0.0/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/Humanoid/releases/v1.0.0)
- First release