<?php 

namespace nz_\uim_;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;

class UIMEvents implements Listener {
    
    public function onInteract(PlayerInteractEvent $e){
        $p = $e->getPlayer();
        $i = $p->getInventory()->getItemInHand();
        $uis = UIMaker::getInstance()->getUiS();
        $conf = UIMaker::getInstance()->getConfig();
        $item = UIMaker::getInstance()->item;
        if ($i->getName() === $item->getName()){
            if (!empty($uis)){
                $ui = UIMaker::getInstance()->getUi($conf->get("default-ui"));
                if ($ui !== null){
                    $ui->getUi($p);
                }
            }
        }
    }
    
    public function onJoin(PlayerJoinEvent $e){
        $p = $e->getPlayer();
        $item = UIMaker::getInstance()->item;
        if (!$p->getInventory()->contains($item)){
            $p->getInventory()->addItem($item);
        }
    }
    
}