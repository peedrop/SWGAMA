<?php
	class ModoProd
	{   
        //atributos
		private  $idModoProd;
        private  $nome;
             
        //construtor
        function __construct() {
            $this->setIdModoProd(0);
            $this->setNome("");
        }

        //toString
		function __toString() 
		{
			return $this->getNome();
		}
        
        //get e set IdModoProd
        function getIdModoProd() {
            return $this->idModoProd;
        }
        function setIdModoProd($idModoProd) {
            $this->idModoProd = intval($idModoProd);
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
