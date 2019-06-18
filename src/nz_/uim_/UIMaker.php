<?php 

namespace nz_\uim_;

use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use pocketmine\plugin\PluginBase;

class UIMaker extends PluginBase {
    
    private static $instance;
    public $item;
    private $uis;
    
    public function onEnable() {
        
        $this->saveDefaultConfig();
        $this->saveResource("instruction.txt", true);
        
        $fapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if ($fapi === null){
            $this->getLogger()->alert("You must install FormAPI plugin to run this plugin!");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return true;
        }
        $item = Item::get($this->getConfig()->get("app"))->setCustomName(TextFormat::colorize($this->getConfig()->get("app-name")));
        Item::addCreativeItem($item);
        $this->item = $item;
        
        $this->getServer()->getPluginManager()->registerEvents(new UIMEvents(), $this);
        $this->getServer()->getLogger()->info(TextFormat::colorize("&b+----------[NEOZ04]----------+"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &eThank you for install my plugin"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &efind the instruction in the plugin folder"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &eIf you found a bug, please let me know! Submit new issue on GitHub"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &eGithub: www.github.com/NEOZ04/UiMaker"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &eInstagram: neoz4_"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &ePlugin has been enable..."));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&b+----------------------------+"));
        
        self::$instance = $this;
        $this->loadUi();
        
    }
    
    public static function getInstance(){
        return self::$instance;
    }
    
    private function getUiConfig(){
        return new Config($this->getDataFolder()."uis.yml");
    }
    
    private function loadUi(){ 
        $uis = $this->getConfig()->getAll();
        unset($uis["app"]);
        unset($uis["app-name"]);
        unset($uis["default-ui"]);
        $this->uis = $uis;
        return true;
    }
    
    public function getUiS(){
        return $this->uis;
    }
    
    /**
     * 
     * @param String $name
     * @return \nz_\uim_\ModalUi
     */
    public function getUi(String $name){
        $uis = $this->uis;
        foreach ($uis as $nm => $v){
            if (strtolower($nm) == strtolower($name)){
                $type = $v["type"];
                switch ($type){
                    case 0:
                        return new ModalUi($name);
                        break;
                    case 1:
                        return new ButtonsUi($name);
                        break;
                    case 2:
                        return new InfoUi($name);
                        break;
                }
            }
        }
        
    }
    
}