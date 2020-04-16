<?php
	require_once 'Despesa.php';
    require_once 'Fornecedor.php';
    require_once 'Insumo.php';
    
	class EntradaDespesa
	{
        private  $idEntDespesa;
		private  $valor;
        private  $data;
        private  $dataVencimento;
        private  $despesa;
        private  $fornecedor;
        private  $insumo;

        function __construct() {
            $this->setIdEntDespesa(0);
            $this->setValor("");
            $this->setData(date('Y-m-d'));
            $this->setDataVencimento("");
			$despesa = new Despesa();
            $this->setDespesa($despesa);
            $fornecedor = new Fornecedor();
            $this->setFornecedor($fornecedor);
            $insumo = new Insumo();
            $this->setInsumo($insumo);
        }
        


        // ID
        function getIdEntDespesa(){
            return $this->idEntDespesa;
        }

        function setIdEntDespesa($idEntDespesa){
            $this->idEntDespesa = intval($idEntDespesa);
        }
        


        // VALOR
        function getValor(){
            return $this->valor;
        }

        function setValor($valor){
            $this->valor = $valor;
        }	
        


        // DATA
        function getData(){
            return $this->data;
        }

        function setData($data){
            $this->data = $data;
        }
        


        // DATA VENCIMENTO
        function getDataVencimento(){
            return $this->dataVencimento;
        }

        function setDataVencimento($dataVencimento){
            $this->dataVencimento = $dataVencimento;
        }
        


        // DESPESA
        function getDespesa(){
            return $this->despesa;
        }

        function setDespesa($despesa){
            $this->despesa = $despesa;
        }
        


        // FORNECEDOR
        function getFornecedor(){
            return $this->fornecedor;
        }
        function setFornecedor($fornecedor){
            $this->fornecedor = $fornecedor;
        }
        


        // INSUMO
        function getInsumo(){
            return $this->insumo;
        }
        function setInsumo($insumo){
            $this->insumo = $insumo;
        }
        
	}
?>
