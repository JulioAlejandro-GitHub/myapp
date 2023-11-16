<?php
require_once 'config.php';

class Logger{
    //----------------------------------------
    private $ruta_archivo;
    private $archivo;
    //----------------------------------------
    public $fecha_actual;
    public $nombre_log;
    public $ruta = LOG_PATH;
    //----------------------------------------
    public function __construct($nombre) {
        $this->nombre_log   = $nombre;        
        $this->ruta_archivo = $this->ruta.$this->nombre_log.'_'.date("Ymd", time()).'.log';
        $this->archivo      = fopen($this->ruta_archivo,"a");
    }
    public function write_log($dato) {
        $this->fecha_actual = date("Y/m/d H:i:s", time());
        $contenido = '['.$this->fecha_actual.'] '.$dato."\n";
        //echo "[".$contenido."]";
        fwrite($this->archivo, $contenido);
    }
    public function close_log() {
        fclose($this->archivo);
    }
}
?>