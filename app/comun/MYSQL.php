<?php
require_once 'config.php';

class MYSQL extends mysqli {
    
    public $sql = '';
    
    public function MYSQL() {
//        if(!$this->ping()){
            $BD_HOST = DB_HOST;
            $BD_USR  = DB_USER;
            $BD_PWD  = DB_PASSWORD;
            $BD_NOM  = DB_NAME;
        
            parent::__construct($BD_HOST, $BD_USR, $BD_PWD, $BD_NOM);
            $this->query("SET NAMES 'utf8'");
            
            if (mysqli_connect_error()) {
                die('Error de conexion ('. mysqli_connect_errno().')'.mysqli_connect_error());
            }
//        }
    }
    
    public function query($sql) {
        if (SQL_DEBUG) {
            echo "<b>SQL :</b> [".$sql."]";
        }
        return parent::query($sql);        
    }
}
?>