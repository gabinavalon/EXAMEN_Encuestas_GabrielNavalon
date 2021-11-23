<?php

/**
 * Métodos y funcionamiento de Candidatos
 *
 * @author Gabriel Navalón Soriano
 */
class CandidatoDAO {
    
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    /**
     * Función que devuelve un array de objetos de clase candidato
     * @param type $orden
     * @param type $campo
     * @return type array de candidatos
     */
    public function obtener_todos() {
        
        $sql = "SELECT * FROM candidatos";
        
        if (!$result = $this->conn->query($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        
        $array_candidatos = array();
        while ($candidato = $result->fetch_object('Candidato')) {
            $array_candidatos[] = $candidato;
        }
        return $array_candidatos;
    }
    
    /**
     * Función que inserta un usuario en la BD
     * @param Candidato $candidato
     * @return boolean true si se inserta false si falla
     */
    public function insertar($candidato){
        //Comprobamos que el parámetro sea de la clase Candidato
        if (!$candidato instanceof Candidato) {
            return false;
        }
        $nombre = $candidato->getNombre();
        $foto = $candidato->getFoto();
     
        $sql = "INSERT INTO candidatos (nombre, foto) VALUES (?,?)";
        // preparamos la consulta
        $stmt = $this->conn->prepare($sql);
        //si la conssulta no se puede preparar da error
        if (!$stmt) {
            die("Error en la SQL: " . $this->conn->error);
        }
        //Ejecución de la consulta
        $stmt->bind_param('ss', $nombre, $foto);
        $stmt->execute();
        $result = $stmt->get_result();
        //Guardo el id que le ha asignado la base de datos en la propiedad id del objeto
        $candidato->setId($this->conn->insert_id);
        return true;
    }
    /**
     * Función que borra un candidato de la base de datos y devuelve true si se ha borrado y false si no
     * @param type $candidato
     */
    public function borrar($candidato){
        if ($candidato == null || get_class($candidato) != 'Candidato') {
            return false;
        }
        $sql = "DELETE FROM candidatos WHERE id = ?";
        
         if (!$stmt = $this->conn->prepare($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        
        $id = $candidato->getId();
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($this->conn->affected_rows == 1) { //si afecta a una fila (se borra) devuelve true
            return true;
        } else {
            return false;
        }
    }
    
    public function obtener_id($id) {
        
        $sql = "SELECT * FROM candidatos WHERE id = ?";
        
        if (!$stmt = $this->conn->prepare($sql)) {
            die("Error en la SQL: " . $this->conn->error);
        }
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_object('Candidato');
    }
    
    
}
