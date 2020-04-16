<?php
	class Arte
	{   
        //atributos
		private  $idArte;
        private  $imagem;
             
        //construtor
        function __construct() {
            $this->setIdArte(0);
            $this->setImagem("");
        }

        //toString
		function __toString() 
		{
			return $this->getImagem();
		}
        
        //get e set IdArte
        function getIdArte() {
            return $this->idArte;
        }
        function setIdArte($idArte) {
            $this->idArte = intval($idArte);
        }

        //get e set imagem
        function getImagem() {
            return $this->imagem;
        }
        function setImagem($imagem) {
            $this->imagem = $imagem;
        }

	}
?>
