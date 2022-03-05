<?php

    include "../vendor/autoload.php";
    include "../app/config/Config.php";

    use App\Libraries\Core;
    use App\Libraries\Populate;

    $populate = new Populate();

    $core = new Core();