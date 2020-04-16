<?php
    require_once 'Blusa.php';
    require_once 'Venda.php';

	class BlusaVenda
	{   
        private  $idBlusaVenda;
		private  $blusa;
        private  $venda;
        private  $valor;
        private  $qtd;
        private  $observacao; // não obrigatório
             
        function __construct() {
            $this->setIdBlusaVenda(0);
            $blusa = new Blusa();
            $this->setBlusa($blusa);
            $venda = new Venda();
            $this->setVenda($venda);
            $this->setValor(0.0);
            $this->setQtd(0);
            $this->setObservacao("");
        }
        
        // id blusa venda
        public function getIdBlusaVenda(){
            return $this->idBlusaVenda;
        }
    
        public function setIdBlusaVenda($idBlusaVenda){
            $this->idBlusaVenda = $idBlusaVenda;
        }

        // blusa
        public function getBlusa(){
            return $this->blusa;
        }
    
        public function setBlusa($blusa){
            $this->blusa = $blusa;
        }
        
        // venda
        public function getVenda(){
            return $this->venda;
        }
    
        public function setVenda($venda){
            $this->venda = $venda;
        }
        
        // valor
        public function getValor(){
            return $this->valor;
        }
    
        public function setValor($valor){
            $this->valor = $valor;
        }
        
        // quantidade
        public function getQtd(){
            return $this->qtd;
        }
    
        public function setQtd($qtd){
            $this->qtd = $qtd;
        }
        
        // observacao
        public function getObservacao(){
            return $this->observacao;
        }
    
        public function setObservacao($observacao){
            $this->observacao = $observacao;
        }

	}
?>
