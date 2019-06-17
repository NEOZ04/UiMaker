<?php 

namespace nz_\uim_;

use pocketmine\Player;
use pocketmine\utils\TextFormat;

class InfoUi extends Ui {
    
    public function __construct(String $name){
        parent::__construct($name);
    }
    
    public function getContent(){
        $c = $this->getContents();
        return (isset($c["content"])) ? $c["content"] : " ";
    }
    
    public function getUi(Player $p){
        $ui = $this->getApi()->createCustomForm(function (Player $p, $data){
            if (is_null($data)) return true;
        });
        $ui->setTitle(TextFormat::colorize($this->getTitle()));
        
        $contents = explode("\\n", $this->getContent());
        if (!empty($contents)){
            foreach ($contents as $label){
                $ui->addLabel($this->translate($p, $label));
            }
        }
        $ui->sendToPlayer($p);
        
    }
    
}