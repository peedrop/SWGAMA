<?php
	require_once 'Banco.php';
	
	abstract class CrudDAO
	{
		
		protected function conectar(){
			return Banco::conectar();
		} 

		protected function desconectar(){
			Banco::desconectar();
		} 		

		abstract function salvar($objeto);
		abstract function incluir($objeto);
		abstract function atualizar($objeto);
		abstract function excluir($objeto);
		abstract function excluirPorId($codigo);
		abstract function listar();
		abstract function buscarPorId($codigo);
	}
	
?> 