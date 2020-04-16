<?php
    require_once 'ModoProd.php';

	class ModeloBlusa
	{   
        //atributos
		private  $idModeloBlusa;
        private  $nome;
        private  $imagem;
        private  $modoProducao;
             
        //construtor
        function __construct() {
            $this->setIdModeloBlusa(0);
            $this->setNome("");
            $this->setImagem("");
            $modoProducao = new ModoProd();
            $this->setModoProducao($modoProducao);
        }

        //toString
		function __toString() 
		{
			return $this->getNome();
		}
        
        //get e set IdModeloBlusa
        function getIdModeloBlusa() {
            return $this->idModeloBlusa;
        }
        function setIdModeloBlusa($idModeloBlusa) {
            $this->idModeloBlusa = intval($idModeloBlusa);
        }

        //get e set nome
        function getNome() {
            return $this->nome;
        }
        function setNome($nome) {
            $this->nome = $nome;
        }

        //get e set imagem
        function getImagem() {
            return $this->imagem;
        }
        function setImagem($imagem) {
            $this->imagem = $imagem;
        }

        //get e set modoProducao
        function getModoProducao() {
            return $this->modoProducao;
        }
        function setModoProducao($modoProducao) {
            $this->modoProducao = $modoProducao;
        }
	}
?>
