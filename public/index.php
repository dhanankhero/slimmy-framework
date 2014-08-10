<?php

// initialize application from bootstrap file
$app = require("../app/app.php");

// index page will call pageHello method from HelloController in Hello Module 
$app->get("/", "@Hello/HelloController:pageHello");

$app->run();