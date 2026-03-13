<?php
interface Controller{
    function getInput(): string;
}

interface Renderer{
    function renderFrame(string $data): void;
}

interface GamePlatformFactory{
    function createController(): Controller;
    function createRender(): Renderer;
}

class KeyboardController implements Controller{
    function getInput(): string{
        return "KeyboardController";
    }
}
class DirectXRenderer implements Renderer {
    function renderFrame(string $data): void{
        echo "motor: ".$data,"<br>";
    }
}
class GamePadController implements Controller{
    function getInput(): string{
        return "GamePadController";
    }
}
class ConsoleRenderer implements Renderer {
    function renderFrame(string $data): void{
        echo "motor: ".$data,"<br>";
    }
}
class EnginePC implements GamePlatformFactory{
    function createController(): Controller{
        return new KeyboardController();
    }
    function createRender(): Renderer{
        return new DirectXRenderer();
    }
}
class EngineConsole implements GamePlatformFactory{
    function createController(): Controller{
        return new GamePadController();
    }
    function createRender(): Renderer{
        return new ConsoleRenderer();
    }
}

class EngineConfigurator {
    public static function getFactory(string $engine): GamePlatformFactory{
        return match($engine){
            'P'=> new EnginePC(),
            'C'=> new EngineConsole(),
            default => throw new Exception("Configuration not found")
        };
    }
}

class GameEngine{
    public GamePlatformFactory $factory;
    private bool $isDebug;
    public function __construct(GamePlatformFactory $factory, bool $isDebug){
        $this->engine = $factory;
        $this->isDebug = $isDebug;
    }

    public function run(int $frames){
        
        $controller = $this->factory->createController();
        $renderer = $this->factory->createRender();

        for( $i = 0; $i < $frames;  $i++ ){
            $input = $controller->getInput();
            if($this->dbg){
                 echo "[DEBUG] Procesando frame: $i | Input: $input <br>";
            }
            $renderer->renderFrame($input);
        }
    }
}


$engineConfigurator = EngineConfigurator::getFactory('C');
$gameEngine = new GameEngine($engineConfigurator, true); // Modo debug true
$gameEngine->run(4);
