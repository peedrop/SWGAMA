<?php
	class Cliente
	{   
        //atributos
		private  $idCliente;
        private  $nome;
        private  $dataNascimento;
        private  $telefone;
        private  $email;
        private  $cpf;
        private  $cnpj;
        private  $tipoPessoa;
        private  $endereco;
             
        //construtor
        function __construct() {
            $this->setIdCliente(0);
            $this->setNome("");
            $this->setDataNascimento("");
            $this->setTelefone("");
            $this->setEmail("");
            $this->setCpf("");
            $this->setCnpj("");
            $this->setTipoPessoa("");
            $this->setEndereco("");
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
        public function getNome(){
            return $this->nome;
        }
        public function setNome($nome){
            $this->nome = $nome;
        }
        
        //get e set dataNascimento
        public function getDataNascimento(){
            return $this->dataNascimento;
        }
        public function setDataNascimento($dataNascimento){
            $this->dataNascimento = $dataNascimento;
        }
        
        //get e set telefone
        public function getTelefone(){
            return $this->telefone;
        }
        public function setTelefone($telefone){
            $this->telefone = $telefone;
        }
        
        //get e set email
        public function getEmail(){
            return $this->email;
        }
        public function setEmail($email){
            $this->email = $email;
        }
        
        //get e set cpf
        public function getCpf(){
            return $this->cpf;
        }
        public function setCpf($cpf){
            $this->cpf = $cpf;
        }
        
        //get e set cnpj
        public function getCnpj(){
            return $this->cnpj;
        }
        public function setCnpj($cnpj){
            $this->cnpj = $cnpj;
        }
        
        //get e set tipoPessoa
        public function getTipoPessoa(){
            return $this->tipoPessoa;
        }
        public function setTipoPessoa($tipoPessoa){
            $this->tipoPessoa = $tipoPessoa;
        }
        
        //get e set endereco
        public function getEndereco(){
            return $this->endereco;
        }
        public function setEndereco($endereco){
            $this->endereco = $endereco;
        }

	}
?>
