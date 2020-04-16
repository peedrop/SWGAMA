<?php
	class Fornecedor
	{   
        //atributos
		private  $idFornecedor;
        private  $nome;
        private  $telefone;
        private  $email;
        private  $endereco;
             
        //construtor
        function __construct() {
            $this->setIdFornecedor(0);
            $this->setNome("");
            $this->setTelefone("");
            $this->setEmail("");
            $this->setEndereco("");
        }

        //toString
		function __toString() 
		{
			return $this->getNome();
		}
        
        //get e set IdFornecedor
        function getIdFornecedor() {
            return $this->idFornecedor;
        }
        function setIdFornecedor($idFornecedor) {
            $this->idFornecedor = intval($idFornecedor);
        }

        //get e set nome
        function getNome() {
            return $this->nome;
        }
        function setNome($nome) {
            $this->nome = $nome;
        }

        //get e set telefone
        function getTelefone() {
            return $this->telefone;
        }
        function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        //get e set email
        function getEmail() {
            return $this->email;
        }
        function setEmail($email) {
            $this->email = $email;
        }

        //get e set endereco
        function getEndereco() {
            return $this->endereco;
        }
        function setEndereco($endereco) {
            $this->endereco = $endereco;
        }

	}
?>
