<?php
	class Funcionario
	{   
		private $idFuncionario;
        private $nome;
        private $cpf;
        private $telefone;
        private $dataNascimento;
        private $sexo;
        private $email;
        private $salario;
        private $dtPagamento;
        private $endereco;
        private $tipo;
        private $usuario;

        function __construct() {
            $this->setIdFuncionario(0);
            $this->setNome("");
            $this->setCpf("");
            $this->setTelefone("");
            $this->setDataNascimento("");
            $this->setSexo("");
            $this->setEmail("");
            $this->setSalario("");
            $this->setDataPag("");
            $this->setEndereco("");
            $this->setTipo("");
            $this->setUsuario(1);
        }

		function __toString() 
		{
			return $this->getDescricao();
		}
        
        function getIdFuncionario() {
            return $this->idFuncionario;
        }
        function setIdFuncionario($idFuncionario) {
            $this->idFuncionario = intval($idFuncionario);
        }

        function getNome() {
            return $this->nome;
        }
        function setNome($nome) {
            $this->nome = $nome;
        }

        function getCpf() {
            return $this->cpf;
        }
        function setCpf($cpf) {
            $this->cpf = $cpf;
        }

        function getTelefone() {
            return $this->telefone;
        }
        function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        function getDataNascimento() {
            return $this->dataNascimento;
        }
        function setDataNascimento($dataNascimento) {
            $this->dataNascimento = $dataNascimento;
        }

        function getSexo() {
            return $this->sexo;
        }
        function setSexo($sexo) {
            $this->sexo = $sexo;
        }

        function getEmail() {
            return $this->email;
        }
        function setEmail($email) {
            $this->email = $email;
        }

        function getSalario() {
            return $this->salario;
        }
        function setSalario($salario) {
            $this->salario = $salario;
        }

        function getDataPag() {
            return $this->dtPagamento;
        }
        function setDataPag($dtPagamento) {
            $this->dtPagamento = $dtPagamento;
        }

        function getEndereco() {
            return $this->endereco;
        }
        function setEndereco($endereco) {
            $this->endereco = $endereco;
        }

        function getTipo() {
            return $this->tipo;
        }
        function setTipo($tipo) {
            $this->tipo = $tipo;
        }

        function getUsuario() {
            return $this->usuario;
        }
        function setUsuario($usuario) {
            $this->usuario = $usuario;
        }
	}
?>
