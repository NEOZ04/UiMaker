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
        $this->saveResource("uis.yml");
        $this->saveResource("instruction.txt", true);
        
        $fapi = $this->getServer()->getPluginManager()->getPlugin("FormAPI");
        if ($fapi === null){
            $this->getLogger()->alert("You must install FormAPI plugin to run this plugin!");
            $this->getServer()->getPluginManager()->disablePlugin($this);
            return true;
        }
        $item = Item::get($this->getConfig()->get("item-to-open"))->setCustomName(TextFormat::colorize($this->getConfig()->get("item-name")));
        Item::addCreativeItem($item);
        $this->item = $item;
        
        $this->getServer()->getPluginManager()->registerEvents(new UIMEvents(), $this);
        $this->getServer()->getLogger()->info(TextFormat::colorize("&b+----------[NEOZ04]----------+"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &eThank you for install my plugin"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &efind the instruction in the plugin folder"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &eIf you found a bug, please let me know! Submit new issue on GitHub"));
        $this->getServer()->getLogger()->info(TextFormat::colorize("&a=> &eGithub: www.github.com/neoz04/UiMaker"));
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
        $this->uis = $this->getUiConfig()->getAll();
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
                        return new SimpleUi($name);
                        break;
                }
            }
        }
        
    }
    
    public function Translate(String $string) {
        $string = str_replace("", "&", $string);
        $string = str_replace("&0", TextFormat::BLACK, $string);
        $string = str_replace("&1", TextFormat::DARK_BLUE, $string);
        $string = str_replace("&2", TextFormat::DARK_GREEN, $string);
        $string = str_replace("&3", TextFormat::DARK_AQUA, $string);
        $string = str_replace("&4", TextFormat::DARK_RED, $string);
        $string = str_replace("&5", TextFormat::DARK_PURPLE, $string);
        $string = str_replace("&6", TextFormat::GOLD, $string);
        $string = str_replace("&7", TextFormat::GRAY, $string);
        $string = str_replace("&8", TextFormat::DARK_GRAY, $string);
        $string = str_replace("&9", TextFormat::BLUE, $string);
        $string = str_replace("&a", TextFormat::GREEN, $string);
        $string = str_replace("&b", TextFormat::AQUA, $string);
        $string = str_replace("&c", TextFormat::RED, $string);
        $string = str_replace("&d", TextFormat::LIGHT_PURPLE, $string);
        $string = str_replace("&e", TextFormat::YELLOW, $string);
        $string = str_replace("&f", TextFormat::WHITE, $string);
        $string = str_replace("&k", TextFormat::OBFUSCATED, $string);
        $string = str_replace("&l", TextFormat::BOLD, $string);
        $string = str_replace("&m", TextFormat::STRIKETHROUGH, $string);
        $string = str_replace("&n", TextFormat::UNDERLINE, $string);
        $string = str_replace("&o", TextFormat::ITALIC, $string);
        $string = str_replace("&r", TextFormat::RESET, $string);
        return $string;
    }
    
}