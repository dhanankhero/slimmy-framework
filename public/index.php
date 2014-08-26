<?php

// initialize application from bootstrap file
$app = require("../App/app.php");

require(APP_PATH."/routes.php");

$app->run();