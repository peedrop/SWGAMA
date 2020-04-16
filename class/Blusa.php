<?php
	require_once 'Gola.php';
    require_once 'ModoProd.php';
    require_once 'Tamanho.php';
    require_once 'TipoMalha.php';
    
	class Blusa
	{
        private  $idBlusa;
		private  $gola;
        private  $modoProd;
        private  $tamanho;
        private  $malha;
        private  $valor;
        private  $qtdEstoque;
        private  $nome;
        private $status;

        function __construct() {
            $this->setIdBlusa(0);
			$gola = new Gola();
            $this->setGola($gola);
            $modoProd = new ModoProd();
            $this->setModoProd($modoProd);
            $tamanho = new Tamanho();
            $this->setTamanho($tamanho);
            $malha = new TipoMalha();
            $this->setMalha($malha);
            $this->setValor(0);
            $this->setEstoque(0);
            $this->setNome("");
            $this->setStatus("");
        }
        
        function getIdBlusa(){
            return $this->idBlusa;
        }

        function setIdBlusa($idBlusa){
            $this->idBlusa = intval($idBlusa);
        }
        
        function getGola(){
            return $this->gola;
        }

        function setGola($gola){
            $this->gola = $gola;
        }	

        function getModoProd(){
            return $this->modoProd;
        }

        function setModoProd($modoProd){
            $this->modoProd = $modoProd;
        }

        function getTamanho(){
            return $this->tamanho;
        }

        function setTamanho($tamanho){
            $this->tamanho = $tamanho;
        }

        function getMalha(){
            return $this->malha;
        }

        function setMalha($malha){
            $this->malha = $malha;
        }

        function getValor(){
            return $this->valor;
        }
        function setValor($valor){
            $this->valor = $valor;
        }

        function getEstoque(){
            return $this->qtdEstoque;
        }
        function setEstoque($qtdEstoque){
            $this->qtdEstoque = $qtdEstoque;
        }

        function getNome(){
            return $this->nome;
        }
        function setNome($nome){
            $this->nome = $nome;
        }

        function getStatus(){
            return $this->status;
        }
        function setStatus($status){
            $this->status = $status;
        }
	}
?>
