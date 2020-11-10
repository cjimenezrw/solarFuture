<?php
require_once('../../../core/config/config.php');
if(session_destroy()){
    header('Location: '.SYS_URL);
}