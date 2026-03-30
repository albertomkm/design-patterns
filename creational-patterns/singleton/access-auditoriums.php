<?php

class AccessAuditoriums {

    private static $instance = null;
    private $auditoriums = [];
    private function __construct() {
        echo "AccessAuditoriums instance created.<br>";
    }
    private function __clone(): void {
        // Prevent cloning
    }

    public static function getInstance(): static {
        if( static::$instance === null ) {
            static::$instance = new static("initialization data");
        }
        return static::$instance;
    }
    public function log(string $level, string $message) : void {
        $timestamp = date('Y-m-d H:i:s');
        $log = "[$timestamp] [$level] $message";
        $this->auditoriums[] = $log;
        // echo $log . "<br>";
    }
    public function getHistory(): array{
        return $this->auditoriums;
    }
}
echo "Accessing AccessAuditoriums singleton instance...<br>";
$logger1 = AccessAuditoriums::getInstance();
$logger2 = AccessAuditoriums::getInstance();

echo "Validating singleton instances...<br>";
if ($logger1 === $logger2) {
    echo "Both logger1 and logger2 reference the same instance.<br>";
} else {
    echo "logger1 and logger2 are different instances.<br>";
}

echo "Recording log entries...<br>";
$logger1->log("INFO", "First log entry. 1"); 
$logger2->log("ERROR", "Second log entry. 2");

echo "Retrieving log history from logger1...<br>";
$history = $logger1->getHistory();
foreach ($history as $entry) {
    echo $entry . "<br>";
}

echo "Retrieving log history from logger2...<br>";
$history = $logger2->getHistory();
foreach ($history as $entry) {
    echo $entry . "<br>";
}