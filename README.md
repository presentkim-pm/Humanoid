[![Telegram](https://img.shields.io/badge/Telegram-PresentKim-blue.svg?logo=telegram)](https://t.me/PresentKim)

[![icon/192x192](meta/icon/192x192.png?raw=true)]()

[![License](https://img.shields.io/github/license/PMMPPlugin/Humanoid.svg?label=License)](LICENSE)
[![Poggit](https://poggit.pmmp.io/ci.shield/PMMPPlugin/Humanoid/Humanoid)](https://poggit.pmmp.io/ci/PMMPPlugin/Humanoid)
[![Release](https://img.shields.io/github/release/PMMPPlugin/Humanoid.svg?label=Release)](https://github.com/PMMPPlugin/Humanoid/releases/latest)
[![Download](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/total.svg?label=Download)](https://github.com/PMMPPlugin/Humanoid/releases/latest)


A plugin add humanoid entity for PocketMine-MP

## Command
Main command : `/humanoid <add | set | remove | copy | cancel | lang | reload | save | skinsteal>`

| subcommand | arguments              | description                 |
| ---------- | ---------------------- | --------------------------- |
| Add        | \[name\]               | Add humanoid                |
| Set        | \<data name\> \[data\] | Change humanoid's data      |
| Remove     |                        | Remove humanoid             |
| Copy       |                        | Copy humanoid               |
| Cancel     |                        | Cancel act                  |
| SkinSteal  |                        | Steal humanoid's skin       |
| Lang       | \<language prefix\>    | Load default lang file      |
| Reload     |                        | Reload all data             |




## Permission
| permission             | default  | description          |
| ---------------------- | -------- | -------------------- |
| humanoid.cmd           | OP       | main command         |
|                        |          |                      |
| humanoid.cmd.add       | OP       | add subcommand       |
| humanoid.cmd.set       | OP       | set  subcommand      |
| humanoid.cmd.remove    | OP       | remove subcommand    |
| humanoid.cmd.copy      | OP       | copy subcommand      |
| humanoid.cmd.cancel    | OP       | cancel subcommand    |
| humanoid.cmd.skinsteal | OP       | skinsteal subcommand |
| humanoid.cmd.lang      | OP       | lang subcommand      |
| humanoid.cmd.reload    | OP       | reload subcommand    |




## \<data name\> list
ex)  `/humanoid Set List 2`

| name       | arguments                                           | description                     |
| ---------- | --------------------------------------------------- | ------------------------------- |
| List       | \[page\]                                            | Show data name list             |
| Name       | \[name\]                                            | Change humanoid's name          |
| Rotation   | \<yaw\> \<pitch\>                                   | Change humanoid's yaw and pitch |
| Item       | \[item id\]                                         | Change humanoid's held item     |
| Armor      | \[item id\]                                         | Change humanoid's Armor         |
| Skin       | \[player name\]                                     | Change humanoid's skin data     |
| Cape       | \[player name\]                                     | Change humanoid's cape data     |
| Geometry   | \[geometry name\]                                   | Change humanoid's geometry name |
| Sneak      |                                                     | Toggle humanoid's sneaking      |
| Position   | \<player name\> or \<x\> \<y\> \<z\> \[world name\] | Change humanoid's position      |
| Scale      | \<scale percent\>                                   | Change humanoid's scale         |




## ChangeLog
### v1.0.0 [![Source](https://img.shields.io/badge/source-v1.0.0-blue.png?label=source)](https://github.com/PMMPPlugin/Humanoid/tree/v1.0.0) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/v1.0.0/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/Humanoid/releases/v1.0.0)
- First release
  
  
---
### v1.0.1 [![Source](https://img.shields.io/badge/source-v1.0.1-blue.png?label=source)](https://github.com/PMMPPlugin/Humanoid/tree/v1.0.1) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/v1.0.1/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/Humanoid/releases/v1.0.1)
- \[Added\] Softdepend https://github.com/PMMPPlugin/GeometryAPI
- \[Fixed\] Humanoid : get geometry data from GeometryAPI
  
  
---
### v1.0.2 [![Source](https://img.shields.io/badge/source-v1.0.2-blue.png?label=source)](https://github.com/PMMPPlugin/Humanoid/tree/v1.0.2) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/v1.0.2/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/Humanoid/releases/v1.0.2)
- \[Fixed\] Humanoid : load geometry data only entity construct
  
  
---
### v1.0.3 [![Source](https://img.shields.io/badge/source-v1.0.3-blue.png?label=source)](https://github.com/PMMPPlugin/Humanoid/tree/v1.0.3) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/v1.0.3/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/Humanoid/releases/v1.0.3)
- \[Added\] Add PluginCommand getter and setter
- \[Added\] Add getters and setters to SubCommand
- \[Fixed\] Add api 3.0.0-ALPHA11
- \[Added\] Add website and description
- \[Changed\] Show only subcommands that sender have permission to use
  
  
---
### v1.0.4 [![Source](https://img.shields.io/badge/source-v1.0.4-blue.png?label=source)](https://github.com/PMMPPlugin/Humanoid/tree/v1.0.4) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/v1.0.4/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/Humanoid/releases/v1.0.4)
- \[Added\] Add skin steal sub command
- \[Fixed\] Save NBT before copy humanoid
  
  
---
### v1.0.5 [![Source](https://img.shields.io/badge/source-v1.0.5-blue.png?label=source)](https://github.com/PMMPPlugin/Humanoid/tree/v1.0.5) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/v1.0.5/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/Humanoid/releases/v1.0.5)
- \[Fixed\] SetHumanoidSkinAct : Only change skin data
- \[Fixed\] SetHumanoidGeometryAct : Only change geometry name
- \[Added\] Add set cape sub command
- \[Added\] Save humanoid's cape data
- \[Added\] Add set armor sub command
- \[Added\] Add inventory to humanoid  for contain armors and held item
- \[Changed\] Command : Change check first parameter logic
- \[Changed\] SetItemCommand : Get item from string
- \[Changed\] Command : Get player by name with auto completion
- \[Removed\] Remove set-success detail message
  
  
---
### v1.0.6 [![Source](https://img.shields.io/badge/source-v1.0.6-blue.png?label=source)](https://github.com/PMMPPlugin/Humanoid/tree/v1.0.6) [![Release](https://img.shields.io/github/downloads/PMMPPlugin/Humanoid/v1.0.6/total.png?label=download&colorB=1fadad)](https://github.com/PMMPPlugin/Humanoid/releases/v1.0.6)
- \[Added\] Add humanoid.cmd.skinsteal permisson
- \[Changed\] Sub command order

