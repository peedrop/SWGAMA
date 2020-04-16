<?php
    require_once 'Cliente.php';

	class Venda
	{   
		private  $idVenda;
        private  $valorTotal;
        private  $desconto;  // não obrigatório
        private  $dataHora;
        private  $observacao; // não obrigatório
        private  $tipo;
        private  $cliente;
             
        function __construct() {
            $this->setIdVenda(0); 
            $this->setValorTotal(0.0);
            $this->setDesconto(0.0);
            $this->setDataHora(date('0000-00-00 00:00:00'));
            $this->setObservacao("");
            $cliente = new Cliente();
            $this->setCliente($cliente);
            $this->setTipo("");
        }

		function __toString() 
		{
			return $this->getIdVenda();
		}
        

        // id venda
        public function getIdVenda(){
            return $this->idVenda;
        }
    
        public function setIdVenda($idVenda){
            $this->idVenda = $idVenda;
        }
        

        // valor total
        public function getValorTotal(){
            return $this->valorTotal;
        }
    
        public function setValorTotal($valorTotal){
            $this->valorTotal = $valorTotal;
        }
        

        // desconto
        public function getDesconto(){
            return $this->desconto;
        }
    
        public function setDesconto($desconto){
            $this->desconto = $desconto;
        }
        

        // data e hora
        public function getDataHora(){
            return $this->dataHora;
        }
    
        public function setDataHora($dataHora){
            $this->dataHora = $dataHora;
        }
        

        // observacao
        public function getObservacao(){
            return $this->observacao;
        }
    
        public function setObservacao($observacao){
            $this->observacao = $observacao;
        }
        

        // cliente
        public function getCliente(){
            return $this->cliente;
        }
    
        public function setCliente($cliente){
            $this->cliente = $cliente;
        }

        // tipo
        public function getTipo(){
            return $this->tipo;
        }
    
        public function setTipo($tipo){
            $this->tipo = $tipo;
        }

	}
?>
