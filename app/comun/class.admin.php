<?php

require_once 'MYSQL.php';

class Admin extends MYSQL {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getSucursales($params=array()) {
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
                    automotora.MAPA                 AS AUTOMOTORA_MAPA,     
                    automotora.FECHA_INGRESO        AS AUTOMOTORA_FECHA_INGRESO,    
                    automotora.FECHA_MODIFICACION   AS AUTOMOTORA_FECHA_MODIFICACION,
                    automotora.ESTADO               AS AUTOMOTORA_ESTADO,     
        
                    ciudad.ID_CIUDAD                AS CIUDAD_ID_CIUDAD,
                    ciudad.ID_REGION                AS CIUDAD_ID_REGION,
                    ciudad.ID_PAIS                  AS CIUDAD_ID_PAIS,
                    ciudad.NOMBRE                   AS CIUDAD_NOMBRE,
                    
                    region.ID_REGION                AS REGION_ID_REGION,
                    region.ID_PAIS                  AS REGION_ID_PAIS,
                    region.NOMBRE                   AS REGION_NOMBRE,
                    region.ORDEN                    AS REGION_ORDEN,
                    
                    pais.ID_PAIS                    AS PAIS_ID_PAIS,
                    pais.NOMBRE                     AS PAIS_NOMBRE,
                    pais.IMG                        AS PAIS_IMG
                FROM 
                    automotora
                    
                LEFT JOIN ciudad       ON ciudad.ID_CIUDAD             =   automotora.ID_CIUDAD
                LEFT JOIN region       ON region.ID_REGION             =   ciudad.ID_REGION
                LEFT JOIN pais         ON pais.ID_PAIS                 =   region.ID_REGION
                ';
        
        $condition_and    = array();
        $condition_manual = array();

        if ($params['AUTOMOTORA_ID_AUTOMOTORA']) {
            array_push($condition_and, 'automotora.ID_AUTOMOTORA = "'.$params['AUTOMOTORA_ID_AUTOMOTORA'].'"');
        }
        //Se trae la matriz y todas sus sucursales
        if ($params['AUTOMOTORA_SUCURSAL']) {
            array_push($condition_manual, 'AND ( automotora.ID_AUTOMOTORA = "'.$params['AUTOMOTORA_SUCURSAL'].'" OR automotora.ID_MATRIZ  = "'.$params['AUTOMOTORA_SUCURSAL'].'")');
        }            
        if ($params['AUTOMOTORA_ID_MATRIZ']) {
            array_push($condition_and, 'automotora.ID_MATRIZ = "'.$params['AUTOMOTORA_ID_MATRIZ'].'"');
        }
        
        if ($params['REGION_ID_REGION']) {
            array_push($condition_and, 'region.ID_REGION = "'.$params['REGION_ID_REGION'].'"');
        }
        
        if ($params['CIUDAD_ID_CIUDAD']) {
            array_push($condition_and, 'ciudad.ID_CIUDAD = "'.$params['CIUDAD_ID_CIUDAD'].'"');
        }
        
        array_push($condition_and, 'automotora.ESTADO <> "inactivo"');

        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }
        
        if ( count($condition_manual) ) {
            $sql .= ' '.implode(' ', $condition_manual);
        }

        $sql .= '
                ORDER BY automotora.NOMBRE
                ';            
        //echo $sql;
        return $this->query($sql);
    }
    
    public function addSucursal($params=array()) {
        $sql = '
                INSERT INTO
                    automotora
                (
                    ID_MATRIZ,
                    RUT,
                    NOMBRE,
                    TELEFONO,
                    EMAIL,
                    FAX,
                    RAZON_SOCIAL,
                    IMG,
                    URL,
                    DIRECCION,
                    ID_CIUDAD,
                    HORARIO_LUN_VIE,
                    HORARIO_SAB,
                    HORARIO_DOM,
                    MAPA,
                    FECHA_INGRESO,
                    FECHA_MODIFICACION,
                    ESTADO                
                )
                VALUES
                (
                    "'.$params['AUTOMOTORA_ID_MATRIZ'].'",
                    "'.$params['AUTOMOTORA_RUT'].'",
                    "'.$params['AUTOMOTORA_NOMBRE'].'",
                    "'.$params['AUTOMOTORA_TELEFONO'].'",
                    "'.$params['AUTOMOTORA_EMAIL'].'",
                    "'.$params['AUTOMOTORA_FAX'].'",
                    "'.$params['AUTOMOTORA_RAZON_SOCIAL'].'",
                    "'.$params['AUTOMOTORA_IMG'].'",
                    "'.$params['AUTOMOTORA_URL'].'",
                    "'.$params['AUTOMOTORA_DIRECCION'].'",
                    "'.$params['AUTOMOTORA_ID_CIUDAD'].'",
                    "'.$params['AUTOMOTORA_HORARIO_LUN_VIE'].'",
                    "'.$params['AUTOMOTORA_HORARIO_SAB'].'",
                    "'.$params['AUTOMOTORA_HORARIO_DOM'].'",
                    "'.$params['AUTOMOTORA_MAPA'].'",
                    NOW(),
                    NOW(),
                    "activo"                
                )
                ';
        
        return $this->query($sql);
    }
    
    public function deleteSucursal($params=array()) {
        $sql = '
                UPDATE
                    automotora
                SET
                    FECHA_MODIFICACION = NOW(),
                    ESTADO             = "inactivo"
                ';
        
        $condition_and    = array();
        $condition_manual = array();

        if ($params['AUTOMOTORA_ID_AUTOMOTORA']) {
            array_push($condition_and, 'automotora.ID_AUTOMOTORA = "'.$params['AUTOMOTORA_ID_AUTOMOTORA'].'"');
        }
        if ($params['AUTOMOTORA_ID_MATRIZ']) {
            array_push($condition_and, 'automotora.ID_MATRIZ = "'.$params['AUTOMOTORA_ID_MATRIZ'].'"');
        }
        //Se trae la matriz y todas sus sucursales
        if ($params['AUTOMOTORA_SUCURSAL']) {
            array_push($condition_manual, 'AND ( automotora.ID_AUTOMOTORA = "'.$params['AUTOMOTORA_SUCURSAL'].'" OR automotora.ID_MATRIZ  = "'.$params['AUTOMOTORA_SUCURSAL'].'")');
        }            
        
        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }
        
        if ( count($condition_manual) ) {
            $sql .= ' '.implode(' ', $condition_manual);
        }
        
        return $this->query($sql);
    }
    
    public function editSucursal($params=array()) {
        $sql = '
                UPDATE
                    automotora
                SET
                    RUT                 = "'.$params['AUTOMOTORA_RUT'].'",
                    NOMBRE              = "'.$params['AUTOMOTORA_NOMBRE'].'",
                    TELEFONO            = "'.$params['AUTOMOTORA_TELEFONO'].'",
                    EMAIL               = "'.$params['AUTOMOTORA_EMAIL'].'",
                    FAX                 = "'.$params['AUTOMOTORA_FAX'].'",
                    RAZON_SOCIAL        = "'.$params['AUTOMOTORA_RAZON_SOCIAL'].'",
                ';
        
        if($params['AUTOMOTORA_IMG']) {
            $sql .= '
                    IMG                 = "'.$params['AUTOMOTORA_IMG'].'",
                ';
        }
        
        $sql .= '
                    URL                 = "'.$params['AUTOMOTORA_URL'].'",
                    DIRECCION           = "'.$params['AUTOMOTORA_DIRECCION'].'",
                    ID_CIUDAD           = "'.$params['AUTOMOTORA_ID_CIUDAD'].'",
                    HORARIO_LUN_VIE     = "'.$params['AUTOMOTORA_HORARIO_LUN_VIE'].'",
                    HORARIO_SAB         = "'.$params['AUTOMOTORA_HORARIO_SAB'].'",
                    HORARIO_DOM         = "'.$params['AUTOMOTORA_HORARIO_DOM'].'",
                    MAPA                = "'.$params['AUTOMOTORA_MAPA'].'",
                    FECHA_MODIFICACION  = NOW()
                ';
        
        $condition_and    = array();
        $condition_manual = array();

        if ($params['AUTOMOTORA_ID_AUTOMOTORA']) {
            array_push($condition_and, 'automotora.ID_AUTOMOTORA = "'.$params['AUTOMOTORA_ID_AUTOMOTORA'].'"');
        }
            
        if ($params['AUTOMOTORA_ID_MATRIZ']) {
            array_push($condition_and, 'automotora.ID_MATRIZ = "'.$params['AUTOMOTORA_ID_MATRIZ'].'"');
        }
        
        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }
        
        if ( count($condition_manual) ) {
            $sql .= ' '.implode(' ', $condition_manual);
        }
        
        return $this->query($sql);
    }

    public function getVendedores($params=array()) {
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

        $condition_and    = array();
        $condition_manual = array();

        if ($params['AUTOMOTORA_ID_AUTOMOTORA']) {
            array_push($condition_and, 'automotora.ID_AUTOMOTORA = "'.$params['AUTOMOTORA_ID_AUTOMOTORA'].'"');
        }
        if ($params['AUTOMOTORA_ID_MATRIZ']) {
            array_push($condition_and, 'automotora.ID_MATRIZ = "'.$params['AUTOMOTORA_ID_MATRIZ'].'"');
        }
        //Se trae los vendedores de la matriz y todas sus sucursales
        if ($params['AUTOMOTORA_SUCURSAL']) {
            array_push($condition_manual, 'AND ( automotora.ID_AUTOMOTORA = "'.$params['AUTOMOTORA_SUCURSAL'].'" OR automotora.ID_MATRIZ  = "'.$params['AUTOMOTORA_SUCURSAL'].'")');
        }            
        if ($params['VENDEDOR_ID_AUTOMOTORA']) {
            array_push($condition_and, 'vendedor.ID_AUTOMOTORA = "'.$params['VENDEDOR_ID_AUTOMOTORA'].'"');
        }
        if ($params['VENDEDOR_ID_VENDEDOR']) {
            array_push($condition_and, 'vendedor.ID_VENDEDOR = "'.$params['VENDEDOR_ID_VENDEDOR'].'"');
        }
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
    
    public function addVendedor($params=array()) {
        $sql = '
                INSERT INTO
                    vendedor
                (
                    ID_AUTOMOTORA,
                    EMAIL,
                    PASSWORD,
                    NOMBRE,
                    APELLIDO_PATERNO,
                    APELLIDO_MATERNO,
                    RUT,
                    TELEFONO,
                    MOVIL,
                    DIRECCION,
                    FECHA_INGRESO,
                    FECHA_MODIFICACION,
                    TIPO               
                )
                VALUES
                (
                    "'.$params['VENDEDOR_ID_AUTOMOTORA'].'",
                    "'.$params['VENDEDOR_EMAIL'].'",
                    "'.sha1($params['VENDEDOR_PASSWORD']).'",
                    "'.$params['VENDEDOR_NOMBRE'].'",
                    "'.$params['VENDEDOR_APELLIDO_PATERNO'].'",
                    "'.$params['VENDEDOR_APELLIDO_MATERNO'].'",
                    "'.$params['VENDEDOR_RUT'].'",
                    "'.$params['VENDEDOR_TELEFONO'].'",
                    "'.$params['VENDEDOR_MOVIL'].'",
                    "'.$params['VENDEDOR_DIRECCION'].'",
                    NOW(),
                    NOW(),
                    "activo"                
                )
                ';
        
        return $this->query($sql);
    }
    
    public function editVendedor($params=array()) {
        $sql  = '
                UPDATE
                    vendedor
                SET
                    EMAIL               = "'.$params['VENDEDOR_EMAIL'].'",
                ';
        
        if($params['VENDEDOR_PASSWORD']) {
            $sql .= '
                        PASSWORD            = "'.sha1($params['VENDEDOR_PASSWORD']).'",
                ';
        }
        
        $sql .= '
                    NOMBRE              = "'.$params['VENDEDOR_NOMBRE'].'",
                    APELLIDO_PATERNO    = "'.$params['VENDEDOR_APELLIDO_PATERNO'].'",
                    APELLIDO_MATERNO    = "'.$params['VENDEDOR_APELLIDO_MATERNO'].'",
                    RUT                 = "'.$params['VENDEDOR_RUT'].'",
                    TELEFONO            = "'.$params['VENDEDOR_TELEFONO'].'",
                    MOVIL               = "'.$params['VENDEDOR_MOVIL'].'",
                    DIRECCION           = "'.$params['VENDEDOR_DIRECCION'].'",
                    FECHA_MODIFICACION  = NOW()
                ';

        $condition_and    = array();
        $condition_manual = array();

        if ($params['VENDEDOR_ID_VENDEDOR']) {
            array_push($condition_and, 'vendedor.ID_VENDEDOR = "'.$params['VENDEDOR_ID_VENDEDOR'].'"');
        }
            
        if ($params['VENDEDOR_ID_AUTOMOTORA']) {
            array_push($condition_and, 'vendedor.ID_AUTOMOTORA = "'.$params['VENDEDOR_ID_AUTOMOTORA'].'"');
        }
        
        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }
        
        if ( count($condition_manual) ) {
            $sql .= ' '.implode(' ', $condition_manual);
        }
        
        return $this->query($sql);
    }
    
    public function deleteVendedor($params=array()) {
        $sql = '
                UPDATE
                    vendedor
                    
                INNER JOIN automotora ON automotora.ID_AUTOMOTORA = vendedor.ID_AUTOMOTORA 
                    
                SET
                    vendedor.FECHA_MODIFICACION = NOW(),
                    vendedor.TIPO               = "eliminado"
                    
                ';
        
        $condition_and    = array();
        $condition_manual = array();

        if ($params['VENDEDOR_ID_VENDEDOR']) {
            array_push($condition_and, 'vendedor.ID_VENDEDOR = "'.$params['VENDEDOR_ID_VENDEDOR'].'"');
        }
        
        //vendedores de la matriz y todas sus sucursales
        if ($params['AUTOMOTORA_SUCURSAL']) {
            array_push($condition_manual, 'AND ( automotora.ID_AUTOMOTORA = "'.$params['AUTOMOTORA_SUCURSAL'].'" OR automotora.ID_MATRIZ  = "'.$params['AUTOMOTORA_SUCURSAL'].'")');
        }            
        
        if ($params['VENDEDOR_ID_AUTOMOTORA']) {
            array_push($condition_and, 'vendedor.ID_AUTOMOTORA = "'.$params['VENDEDOR_ID_AUTOMOTORA'].'"');
        }
            
       if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }
        
        if ( count($condition_manual) ) {
            $sql .= ' '.implode(' ', $condition_manual);
        }
        
        return $this->query($sql);
    }
    
    public function addModelo($params=array()) {
        
        $sql = '
                INSERT INTO
                    modelo
                (
                    ID_MARCA,
               ';
        if ($params['CARROCERIA_ID_CARROCERIA']) {
            $sql.= '
                    ID_CARROCERIA,
                   ';
        }

        $sql.= '
                    NOMBRE                
                )
                VALUES
                (
                    "'.$params['MARCA_ID_MARCA'].'",
                ';
        
        if ($params['CARROCERIA_ID_CARROCERIA']) {
            $sql.= '
                    "'.$params['CARROCERIA_ID_CARROCERIA'].'",
                   ';
        }

        $sql.= '
                    "'.$params['MODELO_NOMBRE'].'"
                )
                ';
        
        return $this->query($sql);
    }
    
}
?>