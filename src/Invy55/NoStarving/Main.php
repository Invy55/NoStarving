<?php

declare(strict_types=1);

namespace Invy55\NoStarving;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;
use pocketmine\event\entity\EntityLevelChangeEvent;
use pocketmine\utils\Config;
use pocketmine\Player;

class Main extends PluginBase implements Listener{
    public function onEnable(){
        $this->saveResource("config.yml");
        $this->saveResource("data.yml");
        $this->dataS = new Config($this->getDataFolder() . "data.yml", Config::YAML);
        $this->data = $this->dataS->getAll();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    public function isStarving(PlayerExhaustEvent $event){
        
        if($this->getConfig()->getAll()['enabled-worlds'] === true or in_array($event->getPlayer()->getLevel()->getName(), $this->getConfig()->getAll()['enabled-worlds'])){
            $event->setCancelled(true);
        }
    }
    public function onWorldChange(EntityLevelChangeEvent $event){
        $entity = $event->getEntity();
        if($entity instanceof Player and $this->getConfig()->getAll()['change-world']) {
            if(in_array($event->getTarget()->getName(), $this->getConfig()->getAll()['enabled-worlds'])){
                $this->data['starving'][$entity->getLowerCaseName()] = [$entity->getFood(), $entity->getSaturation()];
                $this->saveStarvingLevel();
                $entity->setFood(20);
                $entity->addSaturation(1);
            }elseif(isset($this->data['starving'][$entity->getLowerCaseName()])){
                $entity->setFood($this->data['starving'][$entity->getLowerCaseName()][0]);
                $entity->addSaturation($this->data['starving'][$entity->getLowerCaseName()][1]); 
            }else{
                $this->data['starving'][$entity->getLowerCaseName()] = [20, 20];
            }
        }
    }
    public function saveStarvingLevel(){
		$this->dataS->setAll($this->data);
		$this->dataS->save();
	}
}
