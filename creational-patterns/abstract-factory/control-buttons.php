<?php 
interface Button {
    function paint():void;
}
interface Checkbox {
    function paint(): void;
}
interface GUIFactory{
    function createButton():Button;
    function createCheckbox(): Checkbox;
}
class WinFactory implements GUIFactory{
    function createButton(): Button{
        return new WinButton();
    }
    function createCheckbox(): Checkbox{
        return new WinCheckbox;
    }
}

class WinButton implements Button{
    public function __construct(){
        
    }
    public function paint():void{
        echo "<button class='win7-btn'>Check para windows</button>";
    }
}
class WinCheckbox implements Checkbox{
    public function __construct(){
    }
    public function paint():void{
        $id = 'check-'.date('U');
        echo "<label for='{$id}'>Check para windows</label><input id='{$id}' type='checkbox'>";
    }
}

class MacFactory implements GUIFactory{
    function createButton(): Button{
        return new MacButton();
    }
    function createCheckbox(): Checkbox{
        return new MacCheckbox;
    }
}

class MacButton implements Button{
    public function __construct(){
        
    }
    public function paint():void{
        echo "<button class='btn'>Check para Mac</button>";
    }
}
class MacCheckbox implements Checkbox{
    public function __construct(){
    }
    public function paint():void{
        $id = 'check-mac-'.date('U');
        echo "<div><input id='{$id}' type='checkbox' class='mac'><label for='{$id}'>Check para Mac</label></div>";
    }
}

class Application{
    private Button $button;
    private Checkbox $checkbox;
    
    public function __construct(GUIFactory $factory){
        $this->button = $factory->createButton();
        $this->checkbox = $factory->createCheckbox();
    }

    public function render(): void{
        $this->button->paint();
         echo "<br>";
        $this->checkbox->paint();
        echo "<hr>";
    }
}

class OSSelector {
    public static function getFactory(string $OS): GUIFactory{
        return match($OS){
            'windows' => new WinFactory(),
            'mac'     => new MacFactory(),
            default   => throw new Exception("OS no soportado")
        };
    }
}

echo '<link rel="stylesheet" href="./style.css">';
// ------------- buttons for windows ----------------
$winFactory = OSSelector::getFactory('windows');
$app = new Application($winFactory);
$app->render();
// ------------- buttons for mac ----------------
$macFatory = OSSelector::getFactory('mac');
$appMac = new Application($macFatory);
$appMac->render();
// ------------- Do you can create buttons for Linux??? ----------------
// $linuxFatory = OSSelector::getFactory('linux');
// $appLinux = new Application($LinuxFatory);
// $appLinux->render();
