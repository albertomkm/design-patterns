<?php 

abstract class Notifier {

    abstract public function getNotificationTransport(): Notification;

    public function notify(string $message=""):void{
        try{
            if (empty($message)) {
                throw new Exception("Message missing");
            }else{
                $transport = $this->getNotificationTransport();
                $transport->send($message);
            }
        }catch(Throwable $e){
           echo "Error, message not send: ".$e->getMessage();
        }
        
    }
}

class EmailNotifier extends Notifier{ 
    private string $email;
    public function __construct( string $email){
        $this->email = $email;
    }
    public function getNotificationTransport():Notification{
        return new EmailNotification($this->email);
    }

}

class SMSNotifier extends Notifier{ 
    private string $message;

    public function __construct(string $message){
        $this->message = $message;
    }
    public function getNotificationTransport():Notification{
        return new SMSNotification($this->message);
    }
}

interface Notification{
    function send(string $message): void;
}

class EmailNotification implements Notification{
    private string $email;
    public function __construct(string $email){
        $this->email = $email;
    }
    function send(string $message):void{
        echo "Enviando email a: " . $this->email . " con mensaje: " . $message;
    }

}

class SMSNotification implements Notification{
    private string $phoneNumber;
    public function __construct(string $phoneNumber){
        $this->phoneNumber = $phoneNumber;
    }
    function send(string $message):void{
        echo "Enviando SMS a: " . $this->phoneNumber . " con mensaje: " . $message;
    }
}

$notifyEmail = new EmailNotifier("alberto@correo.com");
$notifyEmail->notify("holi");
echo "<br>";
