<?php

require_once 'MYSQL.php';

class Session extends MYSQL {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function loginVendedor($params=array()) {
        $sql = '
                SELECT 
                    automotora.ID_AUTOMOTORA        AS AUTOMOTORA_ID_AUTOMOTORA,
                    automotora.ID_MATRIZ            AS AUTOMOTORA_ID_MATRIZ,
                    automotora.ID_CIUDAD            AS AUTOMOTORA_ID_CIUDAD,
                    automotora.RUT                  AS AUTOMOTORA_RUT,
                    automotora.NOMBRE               AS AUTOMOTORA_NOMBRE,
                    automotora.TELEFONO             AS AUTOMOTORA_TELEFONO,
                    automotora.EMAIL                AS AUTOMOTORA_EMAIL,
                    automotora.FAX                  AS AUTOMOTORA_FAX,
                    automotora.RAZON_SOCIAL         AS AUTOMOTORA_RAZON_SOCIAL,
                    automotora.IMG                  AS AUTOMOTORA_IMG,
                    automotora.URL                  AS AUTOMOTORA_URL,
                    automotora.DIRECCION            AS AUTOMOTORA_DIRECCION,
                    automotora.HORARIO_LUN_VIE      AS AUTOMOTORA_HORARIO_LUN_VIE,
                    automotora.HORARIO_SAB          AS AUTOMOTORA_HORARIO_SAB,
                    automotora.HORARIO_DOM          AS AUTOMOTORA_HORARIO_DOM,
                    automotora.ESTADO               AS AUTOMOTORA_ESTADO,
                    automotora.FECHA_INGRESO        AS AUTOMOTORA_FECHA_INGRESO,
                    automotora.FECHA_MODIFICACION   AS AUTOMOTORA_FECHA_MODIFICACION,

                    ciudad.ID_CIUDAD                AS CIUDAD_ID_CIUDAD,
                    ciudad.ID_REGION                AS CIUDAD_ID_REGION,
                    ciudad.ID_PAIS                  AS CIUDAD_ID_PAIS,
                    ciudad.NOMBRE                   AS CIUDAD_NOMBRE,

                    region.ID_REGION                AS REGION_ID_REGION,
                    region.ID_PAIS                  AS REGION_ID_PAIS,
                    region.NOMBRE                   AS REGION_NOMBRE,
                    region.ORDEN                    AS REGION_ORDEN,
                    
                    vendedor.ID_VENDEDOR            AS VENDEDOR_ID_VENDEDOR,
                    vendedor.ID_AUTOMOTORA          AS VENDEDOR_ID_AUTOMOTORA,
                    vendedor.EMAIL                  AS VENDEDOR_EMAIL,
                    vendedor.PASSWORD               AS VENDEDOR_PASSWORD,
                    vendedor.NOMBRE                 AS VENDEDOR_NOMBRE,
                    vendedor.APELLIDO_PATERNO       AS VENDEDOR_APELLIDO_PATERNO,
                    vendedor.APELLIDO_MATERNO       AS VENDEDOR_APELLIDO_MATERNO,
                    vendedor.RUT                    AS VENDEDOR_RUT,
                    vendedor.TELEFONO               AS VENDEDOR_TELEFONO,
                    vendedor.MOVIL                  AS VENDEDOR_MOVIL,
                    vendedor.DIRECCION              AS VENDEDOR_DIRECCION,
                    vendedor.FECHA_INGRESO          AS VENDEDOR_FECHA_INGRESO,
                    vendedor.FECHA_MODIFICACION     AS VENDEDOR_FECHA_MODIFICACION,
                    vendedor.TIPO                   AS VENDEDOR_TIPO
                FROM
		    vendedor
                    
                INNER JOIN automotora ON automotora.ID_AUTOMOTORA = vendedor.ID_AUTOMOTORA 
                LEFT JOIN ciudad   ON ciudad.ID_CIUDAD       = automotora.ID_CIUDAD
                LEFT JOIN region   ON region.ID_REGION       = ciudad.ID_REGION
                LEFT JOIN pais     ON pais.ID_PAIS           = region.ID_PAIS
            ';

        $condition_and = array();

        if ($params['VENDEDOR_EMAIL']) {
            array_push($condition_and, 'vendedor.EMAIL = "'.$params['VENDEDOR_EMAIL'].'"');
        }
        if ($params['VENDEDOR_PASSWORD']) {
            array_push($condition_and, 'vendedor.PASSWORD = "'.$params['VENDEDOR_PASSWORD'].'"');
        }
        
        array_push($condition_and, 'automotora.ESTADO <> "inactivo"');
        array_push($condition_and, 'vendedor.TIPO <> "eliminado"');

        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }

        $sql .= '
                ORDER BY vendedor.NOMBRE
                ';  
        
        return $this->query($sql);
    }
    
    public function loginVisitante($params=array()) {
        $sql = '
                SELECT
                    visitante.ID_VISITANTE           AS VISITANTE_ID_VISITANTE,
                    visitante.EMAIL                  AS VISITANTE_EMAIL,
                    visitante.PASSWORD               AS VISITANTE_PASSWORD,
                    visitante.NOMBRE                 AS VISITANTE_NOMBRE,
                    visitante.APELLIDO_PATERNO       AS VISITANTE_APELLIDO_PATERNO,
                    visitante.APELLIDO_MATERNO       AS VISITANTE_APELLIDO_MATERNO,
                    visitante.RUT                    AS VISITANTE_RUT,
                    visitante.FECHA_INGRESO          AS VISITANTE_FECHA_INGRESO,
                    visitante.FECHA_MODIFICACION     AS VISITANTE_FECHA_MODIFICACION
                FROM
		    visitante
            ';

        $condition = array();

        if ($params['VISITANTE_EMAIL']) {
            array_push($condition, 'visitante.EMAIL = "'.$params['VISITANTE_EMAIL'].'"');
        }
        if ($params['VISITANTE_PASSWORD']) {
            array_push($condition, 'visitante.PASSWORD = "'.$params['VISITANTE_PASSWORD'].'"');
        }

        if ( count($condition) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition);
        }

        $sql .= '
                ORDER BY visitante.NOMBRE
                ';  
        
        return $this->query($sql);
    }
    
    public function rut_exists($rut) {
        $sql = '
                SELECT
                    COUNT(*) AS RUT_EXISTS
                FROM
                    automotora
                    
                WHERE automotora.RUT = "'.$rut.'" 
               ';
        
        $result = $this->query($sql);
        $count = $result->fetch_assoc();
        
        return $count['RUT_EXISTS'] ? true : false; 
    }
    
    public function email_exists($email) {
        return ( $this->email_vendedor_exists($email) || $this->email_visitante_exists($email) ) ? true : false;
    }
    
    public function email_vendedor_exists($email) {
        $sql = '
                SELECT
                    COUNT(*) AS VENDEDOR_EXISTS
                FROM
                    vendedor
                    
                WHERE vendedor.EMAIL = "'.$email.'" 
               ';
        
        $result = $this->query($sql);
        $count = $result->fetch_assoc();
        
        return $count['VENDEDOR_EXISTS'] ? true : false; 
    }
    
    public function email_visitante_exists($email) {
        $sql = '
                SELECT
                    COUNT(*) AS VISITANTE_EXISTS
                FROM
                    visitante
                    
                WHERE visitante.EMAIL = "'.$email.'" 
               ';
        
        $result = $this->query($sql);
        $count = $result->fetch_assoc();
        
        return $count['VISITANTE_EXISTS'] ? true : false; 
    }    
}
?>