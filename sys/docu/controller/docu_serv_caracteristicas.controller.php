<?php
trait Docu_serv_caracteristicas_Controller {
    
    // PESO DE DOCUMENTO EN MB //
    public function SIZEDO($conf = []){
        $data = ['success' => TRUE, 'message' => NULL, 'messageSQL'=> NULL, 'data' => NULL];

        if(!isset($conf['peso_bytes']) || empty($conf['peso_bytes'])){
            $data['success'] = FALSE;
            $data['message'] = 'Es necesario proporcionar el Peso MB';
            return $data;
        }
        
        if((($conf['peso_bytes'] / 1000) / 1000) > $conf['caracteristica']['sValor']){
            $data['success'] = FALSE;
            $data['message'] = 'EL DOCUMENTO EXCEDE EL PESO MÁXIMO PERMITIDO ('.$conf['caracteristica']['sValor'].'MB), PESO DOCUMENTO: '.number_format((($conf['peso_bytes'] / 1000) / 1000),2).'MB';
            return $data;
        }

        $data['success'] = TRUE;
        $data['message'] = 'CARACTERÍSTICA APLICADA ('.$conf['caracteristica']['sNombre'].')';
        return $data;
    }

    // GENERAR THUMBNAIL //
    public function THUMBN($conf = []){
        $data = ['success' => TRUE, 'message' => NULL, 'messageSQL'=> NULL, 'data' => NULL];
        
        if(!is_dir($conf['directory'])) {
            if(!mkdir($conf['directory'], 0777, TRUE)) {
                $data['success'] = FALSE;
                $data['message'] = 'NO SE PUDO CREAR EL DIRECTORIO DEL THUMBNAIL';
                return $data;
            }
        }

        if(!create_thumbnail($conf['source'], $conf['destination'], $conf['width'], $conf['height'])){
            $data['success'] = FALSE;
            $data['message'] = 'HUBO UN ERROR AL CREAR EL THUMBNAIL DEL DOCUMENTO';
            return $data;
        }

        $data['success'] = TRUE;
        $data['message'] = 'CARACTERÍSTICA APLICADA ('.$conf['caracteristica']['sNombre'].')';
        return $data;
    }

}