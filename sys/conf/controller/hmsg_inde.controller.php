<?php
/**
 * 
 */

Class Hmsg_inde_Controller Extends Conf_Model {
    // PUBLIC VARIABLES //

    //use AutoCompleteTrait;
    // PROTECTED VARIABLES //

    // PRIVATE VARIABLES //
    private $data = array();

    public function __construct(){
        parent::init();
    }

    public function __destruct(){

    }
    public function jsonAccesos(){
         return $datosAccesos = parent::consulta_accesos();
    }

    public function getAccessMsgHistory(){

        $configuraciones = array();
        $configuraciones['query'] = "
            SELECT
                    msgMail.skMensaje,
                    msgMail.skEstatus,
                    msgMail.sEmisor,
                    msgMail.sAsunto,
                    msgMail.sCopia,
                    msgMail.sCopiaOculta,
                    msgMail.sDestinatario,
                    msgMail.sContenido,
                    msgMail.iPrioridad,
                    msgMail.dFechaCreacion,
                    msgMail.dFechaEnvio
            FROM
                core_mensajesCorreos msgMail ";
        
          if(!isset ($_POST['filters'])){
            $configuraciones['query'] .= " WHERE CONVERT(VARCHAR(8), msgMail.dFechaCreacion, 112) = CONVERT(VARCHAR(8), GETDATE(), 112)";
//exit($configuraciones['query']);
        }
        
        // aqui se enviarian los where personalizados por empresa o perfil
        $data = parent::crear_consulta($configuraciones);
        
        if(isset($_POST['generarExcel'])){
            return $data['data'];
        }
        $result = $data['data'];
        $data['data'] = array();
        $i=0;
        while ($row = Conn::fetch_assoc($result)) {
            utf8($row);
            $regla = array(
                "menuEmergente1" => ($row['skEstatus'] == 'IN' ? 1 : 0)
            );
            $data['data'][$i] = array(
                'skMensaje'         => $row['skMensaje'],
                'skEstatus'         => $row['skEstatus'],
                'sEmisor'           => str_replace('&quot;','',$row['sEmisor']),
                'sAsunto'           => $row['sAsunto'],
                'sCopia'            => implode(',', 
                               json_decode(
                                    str_replace('&quot;', '"', 
                                        (isset($row['sCopia'])) ? $row['sCopia'] : '[]'
                                    )
                                )
                            ),
                'sCopiaOculta'      => implode(',', 
                                json_decode(
                                    str_replace('&quot;', '"', 
                                        (isset($row['sCopiaOculta'])) ? $row['sCopiaOculta'] : '[]'
                                    )
                                )
                            ),
                'sDestinatario'     => implode(',', 
                                json_decode(
                                    str_replace('&quot;', '"', 
                                        (isset($row['sDestinatario'])) ? $row['sDestinatario'] : '[]'
                                    )
                                )
                            ),
                'sContenido'        => $row['sContenido'],
                'iPrioridad'        => $row['iPrioridad'],
                'dFechaCreacion'    => ($row['dFechaCreacion'] ? date('d/m/Y H:i:s', strtotime($row['dFechaCreacion'])): ''),
                'dFechaEnvio'       => ($row['dFechaEnvio'] ? date('d/m/Y H:i:s', strtotime($row['dFechaEnvio'])): ''),
                'menuEmergente'     => parent::menuEmergente($regla,$row['skMensaje']),
                'nDestinatarios' => count(
                              json_decode(
                                        str_replace('&quot;', '"', 
                                             (isset($row['sCopia'])) ? $row['sCopia'] : '[]'
                                         )
                                 )+
                              json_decode(
                                    str_replace('&quot;', '"', 
                                        (isset($row['sCopiaOculta'])) ? $row['sCopiaOculta'] : '[]'
                                    )
                                )+
                              json_decode(
                                    str_replace('&quot;', '"', 
                                        (isset($row['sDestinatario'])) ? $row['sDestinatario'] : '[]'
                                    )
                                )
                          )
                 );
            $i++;
        }
        Conn::free_result($result);
        return $data;
        }

    public function generarExcel(){
        $data = $this->getAccessMsgHistory();
        parent::generar_excel($_POST['title'], $_POST['headers'] , $data );
    }
}
