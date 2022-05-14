<?php
    require_once('../config/config.php');
    require_once(CORE_PATH.'src/helper.php');
    require_once(CORE_PATH.'src/DLOREAN.functions.php');
    require_once(CORE_PATH.'src/DLOREAN.connection.php');
    require_once(CORE_PATH.'src/DLOREAN.model.php');
    if(ERROR_LOG){ set_error_handler('errorHandler', E_ALL | E_STRICT); }
    $core = new DLOREAN_Model();
    $core->index();
