<?php

Class Send_noti_Controller Extends Inic_Model {
    // PUBLIC VARIABLES //

    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }

    public function send_notify(){
        $this->data['success'] = TRUE;
        $this->data['message'] = NULL;
        $this->data['datos'] = NULL;
        
        $sql = "SELECT * FROM core_mensajesCorreos WHERE skEstatus = 'NU' ORDER BY dFechaCreacion ASC LIMIT 20";
       
        $result = Conn::query($sql);
        if (!$result) {
            $this->data['success'] = FALSE;
            $this->data['message'] = 'Hubo un error al consultar los correos para la notificación';
            return $this->data;
        }
        $correos = Conn::fetch_assoc_all($result);
        if(empty($correos)){
            return $this->data;

        }
        foreach($correos AS $key=>$correo){
            $sql = "UPDATE FROM core_mensajesCorreos SET skEstatus = 'PO' WHERE skMensaje = ". escape($correo['skMensaje']);
            $result = Conn::query($sql);
            if (!$result) {
                $this->data['success'] = FALSE;
                $this->data['message'] = 'Hubo un error actualizar el estatus del correo a proceso';
            }
        }
        
        foreach($correos AS $key=>$correo){
            
            $mail = $this->sendMail(array(
                'subject' => $correo['sAsunto'],
                'to' => json_decode($correo['sDestinatario'],true),
                'msg' => $correo['sContenido'],
                'cc' => json_decode($correo['sCopia'],true),
                'bcc' => json_decode($correo['sCopiaOculta'],true), 
                'NoLog' => true,
                'send1by1' => (!empty($correo['send1by1']) ? 1 : 0),
                'files'=> (($correo['sFiles']) ? json_decode($correo['sFiles'],true) : FALSE),
                'envioInstantaneo' => 1,
                'senderConf' => array()
            ));
            
            if(!$mail){
                
                $sql = "UPDATE FROM core_mensajesCorreos SET skEstatus = 'NU', dFechaEnvio = NOW() WHERE skMensaje = ". escape($correo['skMensaje']);
                $result = Conn::query($sql);
                if (!$result) {
                    continue;
                }
            }
            
            $sql = "UPDATE core_mensajesCorreos SET skEstatus = 'EN', dFechaEnvio = NOW() WHERE skMensaje = ". escape($correo['skMensaje']);
            $result = Conn::query($sql);
            if (!$result) {
                continue;
            }
        }
        
        return $this->data;
        
    }
}