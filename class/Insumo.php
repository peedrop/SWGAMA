<?php
	class Insumo
	{   
		private  $id;
        private  $nome;
        private  $qtdMin;
        private  $qtdEstoque;
        private  $descricao;
        private  $tipo;
             
        function __construct() {
            $this->setId(0);
            $this->setNome("");
            $this->setQtdMin("");
            $this->setQtdEstoque("");
            $this->setDescricao("");
            $this->setTipo("");
        }

		function __toString() 
		{
			return $this->getNome();
		}
        
        // ID
        function getId() {
            return $this->id;
        }
        function setId($id) {
            $this->id = intval($id);
        }

        // NOME
        function getNome() {
            return $this->nome;
        }
        function setNome($nome) {
            $this->nome = $nome;
        }

        // QTD. MIN.
        function getQtdMin() {
            return $this->qtdMin;
        }
        function setQtdMin($qtdMin) {
            $this->qtdMin = $qtdMin;
        }

        // QTD. ESTOQUE
        function getQtdEstoque() {
            return $this->qtdEstoque;
        }
        function setQtdEstoque($qtdEstoque) {
            $this->qtdEstoque = $qtdEstoque;
        }

        // DESCRIÇÃO
        function getDescricao() {
            return $this->descricao;
        }
        function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        // TIPO
        function getTipo() {
            return $this->tipo;
        }
        function setTipo($tipo) {
            $this->tipo = $tipo;
        }
	}
?>
