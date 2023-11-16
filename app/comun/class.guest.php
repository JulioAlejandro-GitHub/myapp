<?php

require_once 'MYSQL.php';

class Guest extends MYSQL {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function addVisitante($params=array()) {
        $sql = '
                INSERT INTO
                    visitante
                (
                    EMAIL,
                    PASSWORD,
                    NOMBRE,
                    APELLIDO_PATERNO,                
                    APELLIDO_MATERNO,                
                    RUT,
                    FECHA_INGRESO,
                    FECHA_MODIFICACION
                )
                VALUES
                (
                    "'.$params['VISITANTE_EMAIL'].'",
                    "'.sha1($params['VISITANTE_PASSWORD']).'",
                    "'.$params['VISITANTE_NOMBRE'].'",
                    "'.$params['VISITANTE_APELLIDO_PATERNO'].'",
                    "'.$params['VISITANTE_APELLIDO_MATERNO'].'",
                    "'.$params['VISITANTE_RUT'].'",
                    NOW(),
                    NOW()
                )
                ';
        
        return $this->query($sql);
    }
    
}
?>