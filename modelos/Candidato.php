<?php
/**
 * Modelo de Candidato
 *
 * @author Gabriel Navalón Soriano
 */
class Candidato {
    private $id;
    private $nombre;
    private $foto;
    
    //Votos que ha recibido el candidato <array>
    private $votos;
    
    //Getters & Setters
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getFoto() {
        return $this->foto;
    }
    
    //Devuelve un array con los votos que ha recibido este candidato
    function getVotos() {
        
        if (!isset($this->votos)) {
            $votoDAO = new VotoDAO(ConexionBD::conectar());
            $this->votos = $votoDAO->obtenerPorCandidato($this->getId());
        }
        
        return $this->votos;
    }

    function setId($id): void {
        $this->id = $id;
    }

    function setNombre($nombre): void {
        $this->nombre = $nombre;
    }

    function setFoto($foto): void {
        $this->foto = $foto;
    }

    function setVotos($votos): void {
        $this->votos = $votos;
    }


}
