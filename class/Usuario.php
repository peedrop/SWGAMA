<?php
	class Usuario
	{   
        //atributos
		private  $idUsuario;
        private  $nome;
        private  $email;
        private  $senha;
             
        //construtor
        function __construct() {
            $this->setIdUsuario(0);
            $this->setNome("");
            $this->setEmail("");
            $this->setSenha("");
        }

        //toString
		function __toString() 
		{
			return $this->getNome();
		}
        
        //get e set IdUsuario
        function getIdUsuario() {
            return $this->idUsuario;
        }
        function setIdUsuario($idUsuario) {
            $this->idUsuario = intval($idUsuario);
        }

        //get e set nome
        function getNome() {
            return $this->nome;
        }
        function setNome($nome) {
            $this->nome = $nome;
        }

        //get e set email
        function getEmail() {
            return $this->email;
        }
        function setEmail($email) {
            $this->email = $email;
        }

        //get e set senha
        function getSenha() {
            return $this->senha;
        }
        function setSenha($senha) {
            $this->senha = $senha;
        }

	}
?>

