# <img src="https://rawgit.com/PresentKim/SVG-files/master/plugin-icons/humanoid.svg" height="50" width="50"> Humanoid  
__A plugin for [PMMP](https://pmmp.io) :: Add humanoid entity!__  
  
[![license](https://img.shields.io/github/license/organization/Humanoid-PMMP.svg?label=License)](LICENSE)
[![release](https://img.shields.io/github/release/organization/Humanoid-PMMP.svg?label=Release)](../../releases/latest)
[![download](https://img.shields.io/github/downloads/organization/Humanoid-PMMP/total.svg?label=Download)](../../releases/latest)
[![Build status](https://ci.appveyor.com/api/projects/status/xd18ryl4li9rc11m/branch/master?svg=true)](https://ci.appveyor.com/project/PresentKim/humanoid-pmmp/branch/master)
  
## What is this?   
A plugin add humanoid entity for PocketMine-MP

## Command
Main command : `/humanoid <add | set | remove | copy | cancel>`

| subcommand | arguments              | description                 |
| ---------- | ---------------------- | --------------------------- |
| Add        | \[name\]               | Add humanoid                |
| Set        | \<data name\> \[data\] | Change humanoid's data      |
| Remove     |                        | Remove humanoid             |
| Copy       |                        | Copy humanoid               |
| Cancel     |                        | Cancel act                  |




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
