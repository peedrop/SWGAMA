<?php
	class TipoMalha
	{   
        //atributos
		private  $idMalha;
        private  $nome;
             
        //construtor
        function __construct() {
            $this->setIdMalha(0);
            $this->setNome("");
        }

        //toString
		function __toString() 
		{
			return $this->getNome();
		}
        
        //get e set IdMalha
        function getIdMalha() {
            return $this->idMalha;
        }
        function setIdMalha($idMalha) {
            $this->idMalha = intval($idMalha);
        }

        //get e set nome
        function getNome() {
            return $this->nome;
        }
        function setNome($nome) {
            $this->nome = $nome;
        }
	}
?>
