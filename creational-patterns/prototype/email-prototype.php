<?php 
declare(strict_types=1);
class EmptyDataException extends RuntimeException {}
class EmailConfig{
    public string $hora;
    public int $reintentos;
    public string $priority;
    public function toString(): string{
        return "Hora de envió: $this->hora <br> Reintentos: $this->reintentos <br> Prioridad: $this->priority<br><br>";
    }
}
interface EmailTemplate{
    function render(): string;
}
abstract class EmailFactory{
    abstract protected function createEmail(): EmailTemplate;
}

class WelcomeEmailFactory extends EmailFactory {  
    public function createEmail(): EmailTemplate{
        return new WelcomeEmail();
    }
}

class PromoEmailFactory extends EmailFactory {
    public function createEmail(): EmailTemplate{
        return new PromoEmail();
    }
}

abstract class BaseEmail implements EmailTemplate{
    public string $fullName;
    public string $subject;
    public string $remitente;
    public string $message;
    public EmailConfig $config;

    protected function validate(): void {
        $required = ['fullName', 'remitente', 'message'];
        foreach ($required as $field) {
            if (empty($this->$field)) {
                throw new EmptyDataException(
                    "Campo requerido '{$field}' vacío en " . static::class
                );
            }
        }
    }
    public function __clone(): void {
        $this->config = clone $this->config;
    }
}

class WelcomeEmail extends BaseEmail{
    public function __construct() {
        $this->subject = "¡Bienvenido!";
        $this->config = new EmailConfig();
        $this->config->hora = "12:00 P.M";
        $this->config->priority = "media";
        $this->config->reintentos = 2;
    }
    /**
     * @throws EmptyDataException Si algún campo requerido está vacío.
     */
    public function render(): string{
        $this->validate();

        $toString = $this->config->toString();
        return "
                [Asunto: $this->subject - Remitente: $this->remitente ]<br>
                [Estimado: $this->fullName]<br>
                [Mensaje: $this->message]<br>
                [Footer]<br>
                Facebook, twister, linkedin y todo el desmadre...<br>
                Aviso de privacidad
                [/Footer]<br>
                ____________________<br>
                $toString
            ";
    }
}

class PromoEmail extends BaseEmail{
    public string $code;
    public string $discount;

    public function __construct(){
        $this->subject = "Oferta especial";
        $this->config = new EmailConfig();
        $this->config->hora = "9:00 P.M";
        $this->config->priority = "alta";
        $this->config->reintentos = 3;
            
    }
    /**
    * @throws EmptyDataException Si algún campo requerido está vacío.
    */
    public function render(): string{
        $this->validate();

        $toString = $this->config->toString();
        return "
                [Asunto: $this->subject - $this->discount % de descuento]
                [Remitente: $this->remitente ]<br>
                [Estimado: $this->fullName]<br>
                [Mensaje: $this->message]<br>
                [Tú código de descuento es: $this->code]<br>
                [Footer]<br>
                Facebook, twister, linkedin y todo el desmadre...<br>
                Aviso de privacidad
                [/Footer]<br>
                ____________________<br>
                $toString
            ";
    }
}


class CampaignRegistry{
    private array $templates = [];
    
    public function __construct(array $factories){
        foreach($factories as $key => $factory){
            $this->templates[$key]= $factory->createEmail();
        }
    }

    public function getTemplate(string $key): EmailTemplate{
        if( !isset($this->templates[$key])){
            throw new \RuntimeException("Plantilla '{$key}' no encontrada");
        }
        return clone $this->templates[$key];
    }

}

$registry = new CampaignRegistry([
    'bienvenida'=> new WelcomeEmailFactory(),
    'promocional'=> new PromoEmailFactory()
]);

$bienvenida = $registry->getTemplate('bienvenida');
$promocional = $registry->getTemplate('promocional');
$banda = $registry->getTemplate('promocional');

$bienvenida->fullName = "Alberto";
$bienvenida->remitente = "RH SoftMid";
$bienvenida->message = "Estamos aprendiendo patrones de diseño";

$promocional->fullName = "Alberto";
$promocional->remitente = "RH SoftMid";
$promocional->message = "Aprovecha tu código primavera";
$promocional->code = "Primavera";
$promocional->discount = "15";
$promocional->config->hora = "15:30 pm";

$banda->fullName = "Alberto";
$banda->remitente = "RH SoftMid";
$banda->message = "Canjea este mes de marzo";
$banda->code = "Marzo21";
$banda->discount = "20";
$banda->config->reintentos = 4;


echo $bienvenida->render();
echo "<br>______________________________________<br>";
echo $banda->render();
echo "<br>______________________________________<br>";
echo $promocional->render();

