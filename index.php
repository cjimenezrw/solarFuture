<?php
	//header('Location: sys');
	if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['perfiles'])) {
		header('Location: sys/inic/inic-sesi/iniciar-session/');
	}else{
		header('Location: sys/inic/inic-dash/inicio/');
	}
	exit;