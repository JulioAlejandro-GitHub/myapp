<?php

require_once 'MYSQL.php';

class User extends MYSQL {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getFavoritos($params=array()) {
        $sql = '
                SELECT 
                    favorito.ID_FAVORITO            AS FAVORITO_ID_FAVORITO,
                    favorito.ID_VISITANTE           AS FAVORITO_ID_VISITANTE,
                    favorito.ID_VEHICULO            AS FAVORITO_ID_VEHICULO,
                    favorito.TIPO                   AS FAVORITO_TIPO,
                    favorito.FECHA                  AS FAVORITO_FECHA
                FROM 
                    favorito
                ';
        
        $condition_and    = array();
        $condition_manual = array();

        if ($params['FAVORITO_ID_VISITANTE']) {
            array_push($condition_and, 'favorito.ID_VISITANTE = "'.$params['FAVORITO_ID_VISITANTE'].'"');
        }
        
        if ($params['FAVORITO_ID_VEHICULO']) {
            array_push($condition_and, 'favorito.ID_VEHICULO = "'.$params['FAVORITO_ID_VEHICULO'].'"');
        }

        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }
        
        if ( count($condition_manual) ) {
            $sql .= ' '.implode(' ', $condition_manual);
        }

        $sql .= '
                ORDER BY favorito.FECHA ASC
                ';            
        
        return $this->query($sql);
    }

    public function addFavorito($params=array()) {
        $sql = '
                INSERT INTO
                    favorito
                (
                    ID_VISITANTE,
                    ID_VEHICULO,
                    TIPO,
                    FECHA                
                )
                VALUES
                (
                    "'.$params['FAVORITO_ID_VISITANTE'].'",
                    "'.$params['FAVORITO_ID_VEHICULO'].'",
                    "favorito",
                    NOW()
                )
                ';
        
        return $this->query($sql);
    }
    
    public function deleteFavorito($params=array()) {
        $sql = '
                DELETE FROM
                    favorito
                ';
        
        $condition_and    = array();
        $condition_manual = array();

        if ($params['FAVORITO_ID_FAVORITO']) {
            array_push($condition_and, 'favorito.ID_FAVORITO = "'.$params['FAVORITO_ID_FAVORITO'].'"');
        }
        
        if ($params['FAVORITO_ID_VISITANTE']) {
            array_push($condition_and, 'favorito.ID_VISITANTE = "'.$params['FAVORITO_ID_VISITANTE'].'"');
        }
            
        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }
        
        if ( count($condition_manual) ) {
            $sql .= ' '.implode(' ', $condition_manual);
        }
        
        return $this->query($sql);
    }

    public function getVisitantes($params=array()) {
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

        $condition_and    = array();
        $condition_manual = array();

        if ($params['VISITANTE_ID_VISITANTE']) {
            array_push($condition_and, 'visitante.ID_VISITANTE = "'.$params['VISITANTE_ID_VISITANTE'].'"');
        }
        if ($params['VISITANTE_EMAIL']) {
            array_push($condition_and, 'visitante.EMAIL = "'.$params['VISITANTE_EMAIL'].'"');
        }
        if ($params['VISITANTE_PASSWORD']) {
            array_push($condition_and, 'visitante.PASSWORD = "'.$params['VISITANTE_PASSWORD'].'"');
        }
        
        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }

        $sql .= '
                ORDER BY visitante.NOMBRE
                ';  
        
        return $this->query($sql);
    }
    
    public function editVisitante($params=array()) {
        $sql  = '
                UPDATE
                    visitante
                SET
                    EMAIL               = "'.$params['VISITANTE_EMAIL'].'",
                ';
        
        if($params['VISITANTE_PASSWORD']) {
            $sql .= '
                        PASSWORD            = "'.sha1($params['VISITANTE_PASSWORD']).'",
                ';
        }
        
        $sql .= '
                    NOMBRE              = "'.$params['VISITANTE_NOMBRE'].'",
                    APELLIDO_PATERNO    = "'.$params['VISITANTE_APELLIDO_PATERNO'].'",
                    APELLIDO_MATERNO    = "'.$params['VISITANTE_APELLIDO_MATERNO'].'",
                    RUT                 = "'.$params['VISITANTE_RUT'].'",
                    FECHA_MODIFICACION  = NOW()
                ';

        $condition_and    = array();
        $condition_manual = array();

        if ($params['VISITANTE_ID_VISITANTE']) {
            array_push($condition_and, 'visitante.ID_VISITANTE = "'.$params['VISITANTE_ID_VISITANTE'].'"');
        }
        
        if ( count($condition_and) ) {
            $sql .= 'WHERE '.implode(' AND ', $condition_and);
        }
        
        if ( count($condition_manual) ) {
            $sql .= ' '.implode(' ', $condition_manual);
        }
        
        return $this->query($sql);
    }
    
}
?>