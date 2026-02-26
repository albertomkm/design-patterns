<?php 
interface RegionalLogisticsFactory{
    function createTaxCalculator(): TaxCalculator;
    function createShippingLabel(): ShippingLabel;
}
interface TaxCalculator{
    function calculate(float $amount): float;
}
interface ShippingLabel{
    function generate(string $address):string;
}

class MexicoLogisticsFactory implements RegionalLogisticsFactory {
    public function __construct(){}
    function createTaxCalculator(): TaxCalculator{
        return new MexicoTax();
    }
    function createShippingLabel(): ShippingLabel{
        return new MexicoLabel();
    }
}

class MexicoTax implements TaxCalculator {
    private float $iva = 0.16;
    function calculate(float $amount):float{
        return ($amount + ($amount * $this->iva));
    }
}
class MexicoLabel implements ShippingLabel{
    function generate(string $address): string{
        $array = explode('|', $address);
        return "CP: {$array[0]} - País: {$array[1]}";
    }
}

class OrderProcessor {
    private $tax;
    private $label;
    public function __construct(RegionalLogisticsFactory $factory){
        $this->tax = $factory->createTaxCalculator();
        $this->label = $factory->createShippingLabel();
    }
    function processOrder(float $price, string $address): string{
        
        return "Total: {$this->tax->calculate($price)} | Etiqueta: {$this->label->generate($address)}";
    }
}

class LogisticsConfigurator{
    public static function getFactory(string $country): RegionalLogisticsFactory{
        return match($country){
            'mx'=> new MexicoLogisticsFactory(),
            default => throw new Exception("Configuration not found")
        };
    }
}

function getTotalOrder($amount, $address, $country){
    try{
        $config = LogisticsConfigurator::getFactory($country);
        if($config){
            $app = new OrderProcessor($config);
            $resp = $app->processOrder($amount, $address);
            echo json_encode(['message' => $resp]);
        }
    }catch(Exception $t){
        echo json_encode(['message' => 'Configuración no encontrada']);
    }
    
    
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $action = $_POST['action'] ?? '';
    if($action === 'getTotalOrder'){
        $amount = floatval($_POST['amount']);
        $address = $_POST['cp'].'|'.$_POST['country'];
        getTotalOrder($amount, $address, $_POST['country']);
        exit;
    }
}

?>
<form id="purchaseForm" action="./">
    <h3>Finalizar compra</h3>
    <div>
        <label for="">Total: </label>
        <input type="text" name="amount" value="650">
    </div>
    <div> <label for="">País</label>
    <select name="country">
        <option value="">- seleccione el país - </option>
        <option value="mx">México</option>
        <option value="eua">Estados Unidos</option>
    </select>
    </div>
    <div>
        <h4 style="margin:5px 0px">Dirección</h4>
        <label for="">Calle: </label>
        <input type="text" name="calle">
        <label for="">CP: </label>
        <input type="text" 
            inputmode="numeric" 
            pattern="\d{5}" 
            maxlength="5" 
            placeholder="Ej. 97370"
            required
            name="cp">
    </div>
    <input type="submit" value="Enviar">
</form>
<h1>Detalles del envío: <br><span id="tag"></span></h1>
<script>
    window.onload = function(){
        const processFrom = document.getElementById('purchaseForm');
        processFrom.addEventListener('submit', function(event){
        const url = `${origin}/abstract-factory/international-shipping-manager.php`;
        const data = new FormData(processFrom);
        data.append('action','getTotalOrder');
            fetch(url,{
                method: 'POST',
                body:data,
            }).then(resp=>resp.json())
            .then(response=>{
                const span = document.getElementById('tag');
                span.innerHTML = response.message;
            }).catch(console.error);

            event.preventDefault();
        }, false);
    }
</script>