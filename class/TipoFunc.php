<?php
	class TipoFunc
	{   
        //atributos
		private  $idTipoFunc;
        private  $descricao;
        private  $permissao;
             
        //construtor
        function __construct() {
            $this->setIdTipoFunc(0);
            $this->setDescricao("");
            $this->setPermissao("");
        }

        //toString
		function __toString() 
		{
			return $this->getDescricao();
		}
        
        //get e set idTipoFunc
        function getIdTipoFunc() {
            return $this->idTipoFunc;
        }
        function setIdTipoFunc($idTipoFunc) {
            $this->idTipoFunc = intval($idTipoFunc);
        }

        //get e set tipoFunc
        function getDescricao() {
            return $this->descricao;
        }
        function setDescricao($descricao) {
            $this->descricao = $descricao;
        }

        //get e set permissao
        function getPermissao() {
            return $this->permissao;
        }
        function setPermissao($permissao) {
            $this->permissao = $permissao;
        }

	}
?>
