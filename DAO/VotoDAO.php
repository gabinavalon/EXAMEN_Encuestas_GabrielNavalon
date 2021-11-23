<?php

/**
 * Métodos y funcionamiento de los Votos
 *
 * @author Gabriel Navalón Soriano
 */
class VotoDAO {
    
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    /**
     * Devuelve true si existe un voto con la ip o false en caso contrario
     * @param type $ip
     */
    public function existe($ip){
        $sql = "SELECT * FROM votos WHERE ip_cliente='$ip'";
        
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        if(null!=$result->fetch_object('Voto')){ //Realiza la consulta, si no encuentra ningún voto, devuelve false, si lo encuentra, true.
            return true;
        }
       
            return false ;
  
    }
    
    /**
     * Inserta un voto en la tabla con los datos del objeto, delvuelve 
     * true si se inserta y false si no
     * @param type $voto
     */
    public function insertar($voto){
        //Comprobamos que el voto introducido es un objeto tipo Voto
        if (!$voto instanceof Voto) {
            return false;
        }

        $id_candidato = $voto->getId_candidato();
        $ip_cliente =  $voto->getIp_cliente();


        $sql = "INSERT INTO votos (id_candidato, ip_cliente) VALUES (?,?)";

        $stmt = $this->conn->prepare($sql); // preparamos la consulta
        if (!$stmt) { // si no se puede preparar, error
            die("Error en la SQL: " . $this->conn->error);
        }
        
        
        $stmt->bind_param('is',  $id_candidato, $ip_cliente); //Consulta preparada
        $stmt->execute();
        $result = $stmt->get_result();

        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $voto->setId($this->conn->insert_id);
        return true;
    }
    
    /**
     * Devuelve un array con todos los votos del candidato
     * @param type $id_candidato
     */
    public function obtenerPorCandidato($id_candidato){
        $sql = "SELECT * FROM votos WHERE id_candidato=$id_candidato";
        
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        $array_votos = array();
        while ($voto = $result->fetch_object('Voto')) {
            $array_votos[] = $voto;
        }
        return $array_votos;
    }
}
