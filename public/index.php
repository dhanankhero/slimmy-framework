<?php

// initialize application from bootstrap file
$app = require("../app/app.php");

require(APP_PATH."/routes.php");

$app->run();