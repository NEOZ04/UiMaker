<?php 

namespace nz_\uim_;

use pocketmine\Player;
use pocketmine\utils\TextFormat;

class ModalUi extends Ui {
    
    public function __construct(String $name){
        parent::__construct($name);
    }
    
    public function getContent(){
        $c = $this->getContents();
        return (isset($c["content"])) ? TextFormat::colorize($c["content"]) : null;
    }
    
    public function getButton1(){
        $c = $this->getContents();
        return (isset($c["button1"])) ? TextFormat::colorize($c["button1"]) : null;
    }
    
    public function getButton2(){
        $c = $this->getContents();
        return (isset($c["button2"])) ? TextFormat::colorize($c["button2"]) : null;
    }
    
    private function check(){
        if (!is_null($this->getContent())){
            return true;
        }elseif (!is_null($this->getButton1())){
            return true;
        }elseif (!is_null($this->getButton2())){
            return true;
        }elseif (!is_null($this->getTitle())){
            return true;
        }
        return false;
    }
    
    public function getUi(Player $p){
        if (!$this->check()){
            $p->sendMessage(TextFormat::colorize("&cForm belum lengkap"));
            return true;
        }
        $ui = $this->getApi()->createModalForm(function (Player $p, $data){
            if ($data === null){
                return true;
            }
            if ($data){
                $cmd = (isset($this->getCommands()["button1"])) ? $this->getCommands()["button1"] : null;
                $this->SendCommand($p, $cmd);
            }else{
                $cmd = (isset($this->getCommands()["button2"])) ? $this->getCommands()["button2"] : null;
                $this->SendCommand($p, $cmd);
            }
        });
        $ui->setTitle(TextFormat::colorize($this->getTitle()));
        $ui->setContent($this->getContent());
        $ui->setButton1(TextFormat::colorize($this->getButton1()));
        $ui->setButton2(TextFormat::colorize($this->getButton2()));
        $ui->sendToPlayer($p);
    }
    
}