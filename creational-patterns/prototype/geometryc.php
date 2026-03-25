<?php 
namespace RefactoringGuru\Prototype\Conceptual;

class Prototype{
    public $primitive;
    public $component;
    public $circularReference;

    public function __clone(){
        $this->component = clone $this->component;
        $this->circularReference = clone $this->circularReference;

        $this->circularReference->prototype = $this;
    }
}

class ComponentWithBackReference{
    public $prototype;
    public function __construct(Prototype $prototype){
        $this->prototype = $prototype;
    }
}

function clientCode(){
    $p1 = new Prototype();
    $p1->primitive = 245;
    $p1->component = new \DateTime();
    $p1->circularReference = new ComponentWithBackReference($p1);

    $p2 = clone $p1;

    if( $p1->primitive === $p2->primitive ){
        echo "{$p1->primitive}<br>";
        $p1->primitive = 400;
        echo "{$p2->primitive}<br>";
        echo "{$p1->primitive}<br>";
    }else{
        echo "Primitive field values have not been copied. Booo!<br>";
    }
}

clientCode();