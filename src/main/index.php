<?php

namespace phptests;

chdir(dirname(__FILE__));

require_once('../../vendor/autoload.php');

use phptests\Module;

// $dbh = new PDO('mysql:host=localhost;port=3380;dbname=phptests', 'root', 'changeme1');

$module = new Module();

$serviceManager = $module->init();

print_r($serviceManager);

$couchdb = $serviceManager->get('couchClient');
$pdo = $serviceManager->get('phptests\Common\Database\PdoAdapter');

// print_r($client);
var_dump($pdo);