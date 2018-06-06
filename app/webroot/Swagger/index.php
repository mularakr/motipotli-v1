<?php

require("vendor/autoload.php");
$swagger = \Swagger\scan('project.php');

header('Content-Type: application/json');
echo $swagger;


?>
