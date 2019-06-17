<?php 

namespace nz_\uim_;

use pocketmine\Player;
use pocketmine\utils\TextFormat;

abstract class Ui {
    
    protected $name;
    
    public function __construct(String $name){
        $this->name = strtolower($name);
    }
    
    protected function getApi(){
        return UIMaker::getInstance()->getServer()->getPluginManager()->getPlugin("FormAPI");
    }
    
    protected function getData(){
        $uis = UIMaker::getInstance()->getUiS();
        foreach ($uis as $name => $v){
            if (strtolower($name) == $this->name){
                return $v;
            }
        }
    }
    
    protected function getContents(){
        return $this->getData()["contents"];
    }
    
    protected function getCommands(){
        return $this->getData()["commands"];
    }
    
    public function getName(){
        return $this->name;
    }
    
    public function getTitle(){
        $c = $this->getContents();
        return (isset($c["title"])) ? $c["title"] : "Ui Maker by NEOZ04";
    }
    
    public function SendCommand(Player $p, $cmd){
        if (is_string($cmd)){
            if (strpos($cmd, "%SM::") === 0){
                $string = substr($cmd, 5);
                $p->sendMessage($this->translate($p,$string));
            }elseif (strpos($cmd, "%OPEN::") === 0){
                $string = substr($cmd, 7);
                $ui = UIMaker::getInstance()->getUi($string);
                $ui->getUi($p);
            }elseif (strpos($cmd, "%CMD::") === 0){
                $string = substr($cmd, 6);
                UIMaker::getInstance()->getServer()->getCommandMap()->dispatch($p, $this->translate($p,$string));
            }
        }
    }
    
    abstract public function getUi(Player $p);
    
    private function translate(Player $p, $string){
        
        $world = $p->getLevel()->getName();
        $name = $p->getName();
        
        $string = str_replace("%PLAYER::l", strtolower($name), $string);
        $string = str_replace("%PLAYER::u", strtoupper($name), $string);
        $string = str_replace("%PLAYER", $name, $string);
        $string = str_replace("\n", PHP_EOL, $string);
        $string = TextFormat::colorize($string);
        
        return $string;
        
    }
    
}