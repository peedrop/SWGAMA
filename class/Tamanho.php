<?php
	class Tamanho
	{   
        //atributos
		private  $idTamanho;
        private  $tamanho;
        private  $altura;
        private  $largura;
             
        //construtor
        function __construct() {
            $this->setIdTamanho(0);
            $this->setTamanho("");
            $this->setAltura("");
            $this->setLargura("");
        }

        //toString
		function __toString() 
		{
			return $this->getTamanho();
		}
        
        //get e set IdTamanho
        function getIdTamanho() {
            return $this->idTamanho;
        }
        function setIdTamanho($idTamanho) {
            $this->idTamanho = intval($idTamanho);
        }

        //get e set tamanho
        function getTamanho() {
            return $this->tamanho;
        }
        function setTamanho($tamanho) {
            $this->tamanho = $tamanho;
        }

        //get e set altura
        function getAltura() {
            return $this->altura;
        }
        function setAltura($altura) {
            $this->altura = $altura;
        }

        //get e set largura
        function getLargura() {
            return $this->largura;
        }
        function setLargura($largura) {
            $this->largura = $largura;
        }

	}
?>
