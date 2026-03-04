<?php 
interface Builder{
    public function setHeader(int $folio, string $firma): void;
    public function setData(string $data): void;
    public function setFooter(string $firma, string $fecha): void;
    public function getResult(): Contract;
}

class Contract{
    public array $parts = [];
    public function addPart(string $part): void{
        $this->parts[] = $part;
    }
    public function render(): string {
        return implode("<br>", $this->parts);
    }
}

class ArrendamientoBuilder implements Builder{
    private Contract $contract;
    
    public function __construct(){
        $this->reset();
    }
    private function reset(): void{
        $this->contract = new Contract();
    }
    public function setHeader(int $folio, string $firma): void{
        $this->contract->addPart("[------Folio: {$folio}-------]");
        $this->contract->addPart("[------Firma: {$firma}-------]");
    }
    public function setData(string $data): void{
        $this->contract->addPart("Clausulas: {$data}");
    }
    public function setDescription(string $description): void{
         $this->contract->addPart("Este contrato es para x cosa: {$description}");
    }
    public function setAmount(float $amount, bool $deposito): void{
        $haSidoDepositado = 'NO';
        if($deposito){
            $haSidoDepositado = 'Sí';
        }
        $this->contract->addPart("Siendo la cantidad: {$amount} y ha sido depositado: {$haSidoDepositado}");
    }
    public function setFooter($firma, $fecha): void{
        $this->contract->addPart("[------Firma: {$firma}-------] <br> [_______con fehca: {$fecha}_______]");
    }
    public function getResult(): Contract{
        $result = $this->contract;
        $this->reset();
        return $result;
    }
}

class ServiciosProfesionalesBuilder implements Builder{
    private Contract $contract;
    public function __construct(){
        $this->reset();
    }
    private function reset(): void{
        $this->contract = new Contract();
    }

    public function setHeader(int $folio, string $firma):void{
        $this->contract->addPart("[------Folio: {$folio}-------]");
        $this->contract->addPart("[------Firma: {$firma}-------]");
    }
    public function setData(string $description):void{
        $this->contract->addPart("servicio: {$description}");
        
    }
    public function setClienteProveedor(string $cliente, string $proveedor):void{
        $this->contract->addPart("cliente: {$cliente}, proveedor: {$proveedor}");
    }
     public function setHonorarios(string $honorario, string $formaDePago):void{
        $this->contract->addPart("Honorario: {$honorario}, forma de pago: {$formaDePago}");
    }
    public function setFooter(string $firma,  string $fecha):void{
        $this->contract->addPart("[------Firma: {$firma}-------] <br> [_______con fehca: {$fecha}_______]");
    }
    public function getResult():Contract{
        $result = $this->contract;
        $this->reset();
        return $result;
    }
}

class Director {
    
    public function buildArrendamiento(Builder $builder, int $folio, string $firma, string $data, string $description, float $amount, string $fecha, bool $deposito): void{
        $builder->setHeader($folio, $firma);
        $builder->setData($data);
        $builder->setDescription($description);
        $builder->setAmount($amount, $deposito);
        $builder->setFooter($firma, $fecha);
    }
    public function buildServiciosProfesionales(Builder $builder, int $folio, string $firma, string $data, string $description, float $amount, string $fecha, string $metodo): void{
        $builder->setHeader($folio, $firma);
        $builder->setData($data);
        $builder->setHonorarios($amount, $metodo);
        $builder->setFooter($firma, $fecha);
    }
}

    $folio = 234234;
    $firma = "firma";
    $data = "data";
    $amount = 150.55;
    $deposito = true;
    $metodo = 'Paypal';
    $description = "SOY la descpricion";
    $fecha = date("d-m-Y");

$builder = new ArrendamientoBuilder();
$director = new Director();
$director->buildArrendamiento($builder, $folio, $firma, $data, $description, $amount, $fecha, $deposito);
$contract = $builder->getResult();
echo $contract->render();
echo "<br><br>";
$builder2 = new ServiciosProfesionalesBuilder();
$director->buildServiciosProfesionales($builder2, $folio, $firma, $data, $description, $amount, $fecha, $metodo);
$contract = $builder2->getResult();
echo $contract->render();