# NoStarving
A Pocketmine-MP plugin that permits you to disable starving in certain worlds.

## Config
Config is located in the plugin data folder in your pocketmine server folder, with config.yml as name.

> ```#-------------------------------------#
> # Worlds where you starving is disabled
> # Set to true to allow all the worlds
> enabled-worlds:
>   - world
> #-------------------------------------#
> # Fill the hunger bar when teleported
> # to an enabled world
> change-world: true
> #-------------------------------------#
> ```

### You can edit 2 lines:
 - First is the **enabled worlds list**, in which starving will be disabled. You can add as many as you want.
 - Second the **change-world option**, is set as default on true. It will always fill the food bar when the player teleport to an **enabled world** and then set it back when he teleport back or to another _not enabled_ world.


## For curious people
data.yml is a simple YAML file used to save food and saturation level when entering an enabled world, that will be read then when exiting that world to _"reset"_ that values.
