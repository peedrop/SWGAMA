<?php
	class Estoque
	{   
		private  $idEstoque;
        private  $tipo;
        private  $data;
        
        function __construct() {
            $this->setIdEstoque(0);
            $this->setTipo("");
            $this->setData("");
        }

		function __toString() 
		{
			return $this->getTipo();
		}
        
        function getIdEstoque() {
            return $this->idEstoque;
        }
        function setIdEstoque($idEstoque) {
            $this->idEstoque = intval($idEstoque);
        }

        function getData() {
            return $this->data;
        }
        function setData($data) {
            $this->data = $data;
        }

        function getTipo() {
            return $this->tipo;
        }
        function setTipo($tipo) {
            $this->tipo = $tipo;
        }
	}
?>
