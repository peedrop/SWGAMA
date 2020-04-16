<?php
	class ClienteTeste
	{   
        //atributos
		private  $idCliente;
        private  $nome;
        private  $idade;
             
        //construtor
        function __construct() {
            $this->setIdCliente(0);
            $this->setNome("");
            $this->setIdade(0);
        }

        //toString
		function __toString() 
		{
			return $this->getNome();
		}
        
        //get e set IdCliente
        function getIdCliente() {
            return $this->idCliente;
        }
        function setIdCliente($idCliente) {
            $this->idCliente = intval($idCliente);
        }

        //get e set nome
        function getNome() {
            return $this->nome;
        }
        function setNome($nome) {
            $this->nome = $nome;
        }

        //get e set idade
        function getIdade() {
            return $this->idade;
        }
        function setIdade($idade) {
            $this->idade = intval($idade);
        }

	}
?>
