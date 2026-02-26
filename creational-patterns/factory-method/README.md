## Misión:
Crea un sistema donde puedas añadir diferentes canales de envío para mensajes.

#### 1. La Interfaz del Producto (Notification)
Define qué debe saber hacer cualquier "notificador" (el envío real).

    Método: send(string $message): void

#### 2. Los Productos Concretos
Crea al menos dos clases que implementen la interfaz:

    EmailNotification: Debe imprimir algo como "Enviando Email: [mensaje]".
    SMSNotification: Debe imprimir algo como "Enviando SMS: [mensaje]".

#### 3. El Creador Abstracto (Notifier)
Esta es la clase "Jefa".

    Debe tener el Factory Method abstracto: getNotificationTransport(): Notification.
    Debe tener el método de lógica de negocio: notify(string $message). Este método debe llamar al factory method, obtener el transporte y luego ejecutar el send().

####  4. Los Creadores Concretos

    EmailNotifier: Devuelve una instancia de EmailNotification.
    SMSNotifier: Devuelve una instancia de SMSNotification.

El reto extra (Opcional pero recomendado):
Para que veas el poder del patrón, intenta que el EmailNotifier pida en su constructor una dirección de correo, y que el SMSNotifier pida un número de teléfono.