<?php

session_start();

session_destroy();

header('Location: ../input/index.php');