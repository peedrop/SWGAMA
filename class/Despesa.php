<?php
	class Despesa{
        
        private  $idDespesa;
        private  $nome;
                
        function __construct() {
            $this->setIdDespesa(0);
            $this->setNome("");
        }

		function __toString(){
			return $this->getIdDespesa();
		}
        
        public function getIdDespesa(){
            return $this->idDespesa;
        }

        public function setIdDespesa($idDespesa){
            $this->idDespesa = $idDespesa;
        }

        public function getNome(){
            return $this->nome;
        }

        public function setNome($nome){
            $this->nome = $nome;
        }
	}
?>
