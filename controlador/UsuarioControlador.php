<?php

    require_once '../class/UsuarioDAO.php';
    
	$usuarioDAO = new UsuarioDAO();
	$usuario = new Usuario();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':

			$usuario->setIdUsuario($_POST["idUsuario"]);
			$usuario->setNome($_POST["nome"]);
            $usuario->setEmail($_POST["email"]);
            $usuario->setSenha($_POST["senha"]);


			$resultado = $usuarioDAO->salvar($usuario);		

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/UsuarioFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/UsuarioFormulario.php?resultado=erro';</script>"; 			
			}

        	break; 

        case 'excluir':
			
			$resultado = $usuarioDAO->excluirPorId($_GET["idUsuario"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/UsuarioTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/UsuarioTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>