# Humanoid [![license](https://img.shields.io/github/license/Blugin/Humanoid-PMMP.svg?label=License)](LICENSE)
<img src="https://rawgit.com/PresentKim/SVG-files/master/plugin-icons/humanoid.svg" height="256" width="256">  

[![release](https://img.shields.io/github/release/Blugin/Humanoid-PMMP.svg?label=Release) ![download](https://img.shields.io/github/downloads/Blugin/Humanoid-PMMP/total.svg?label=Download)](https://github.com/Blugin/Humanoid-PMMP/releases/latest)


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