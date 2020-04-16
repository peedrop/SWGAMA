<?php
    require_once 'Estoque.php';
    require_once 'Blusa.php';

	class BlusaEstoque
	{   
		private  $idBlusaEstoque;
        private  $blusa;
        private  $estoque;
        private  $qtd;

        private static $inicioScript = "<script>";
        private static $fimScript = "</script>";
        
        function __construct() {
            $this->setIdBlusaEstoque(0);
            $estoque = new Estoque(); 
            $this->setEstoque($estoque);
            $this->setQuantidade(0);
        }

        function criarObjetoJS($obj){
            $id = "id: " . $obj->getBlusa()->getIdBlusa() . ", ";
            $idBlusaEstoque = "idBlusaEstoque: " . $obj->getIdBlusaEstoque() . ", ";
            $nome = "nome: '" . $obj->getBlusa()->getNome() . "', ";
            $quantidade = "qtd: " . $obj->getQuantidade();
            $criaObj = "var blusaEstoque = {" .$idBlusaEstoque.$id.$nome.$quantidade ." };";

            $script = BlusaEstoque::$inicioScript. $criaObj .BlusaEstoque::$fimScript;
            return $script;
        }

        function getIdBlusaEstoque(){
            return $this->idBlusaEstoque;
        }
        function setIdBlusaEstoque($idBlusaEstoque){
            $this->idBlusaEstoque = intval($idBlusaEstoque);
        }

        function getEstoque() {
            return $this->estoque;
        }
        function setEstoque($estoque) {
            $this->estoque = $estoque;
        }

        function getBlusa() {
            return $this->blusa;
        }
        function setBlusa($blusa) {
            $this->blusa = $blusa;
        }

        function getQuantidade() {
            return $this->qtd;
        }
        function setQuantidade($qtd) {
            $this->qtd = intval($qtd);
        }
	}
?>
