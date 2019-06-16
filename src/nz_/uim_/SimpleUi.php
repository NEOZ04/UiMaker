<?php 

namespace nz_\uim_;

use pocketmine\Player;
use pocketmine\utils\TextFormat;

class SimpleUi extends Ui {
    
    public function __construct(String $name){
        parent::__construct($name);
    }
    
    public function getButtons(){
        $c = $this->getContents();
        return (isset($c["buttons"])) ? $c["buttons"] : null;
    }
    
    public function getUi(Player $p){
        
        $ui = $this->getApi()->createSimpleForm(function (Player $p, $data){
            if (is_null($data)) return true;
            if (!empty($this->getButtons())){
                $cmd = (isset($this->getCommands()[$data])) ? $this->getCommands()[$data] : null;
                $this->SendCommand($p, $cmd);
                return true;
            }
        });
        $ui->setTitle(TextFormat::colorize($this->getTitle()));
        if (!empty($this->getButtons())){
            foreach ($this->getButtons() as $name){
                $ui->addButton(TextFormat::colorize($name));
            }
        }else{
            $ui->addButton(TextFormat::colorize("&l&cCLOSE"));
        }
        $ui->sendToPlayer($p);
        
    }
    
}