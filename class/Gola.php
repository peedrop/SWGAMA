<?php
	class Gola
	{   
		private  $idGola;
        private  $nome;
             
        function __construct() {
            $this->setIdGola(0);
            $this->setNome("");
        }

		function __toString() 
		{
			return $this->getNome();
		}
        
        function getIdGola() {
            return $this->idGola;
        }
        function setIdGola($idGola) {
            $this->idGola = intval($idGola);
        }

        function getNome() {
            return $this->nome;
        }
        function setNome($nome) {
            $this->nome = $nome;
        }
	}
?>
