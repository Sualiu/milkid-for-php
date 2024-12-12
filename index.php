<?php
require __DIR__ . '/src/IdGenerator.php';

use MilkID\IdGenerator;

// Example usage
$generator = new IdGenerator([
    'fingerprint' => true,
    'timestamp' => true,
]);

$id = $generator->createId('user123-Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, dcko-Compatible) Chrome/118.0.0.0 Safari/537.36-machine_abc-12345-192.168.1.100-1000-counter_5');
echo $id . "\n";
