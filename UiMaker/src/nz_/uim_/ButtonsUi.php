<?php 

namespace nz_\uim_;

use pocketmine\Player;
use pocketmine\utils\TextFormat;

class ButtonsUi extends Ui {
    
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
        $ui->setTitle($this->translate($p, $this->getTitle()));
        $i=1;
        if (!empty($this->getButtons())){
            foreach ($this->getButtons() as $name){
                if (is_null($name)){
                    $name = "&l&cButton ".$i;
                    $i++;
                }
                $ui->addButton($this->translate($p, $name));
            }
        }else{
            $ui->addButton(TextFormat::colorize("&l&cCLOSE"));
        }
        $ui->sendToPlayer($p);
        
    }
    
}