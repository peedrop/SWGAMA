<?php

    require_once '../class/ModeloBlusaDAO.php';
    require_once '../class/ModoProdDAO.php';
    
	$modeloBlusaDAO = new ModeloBlusaDAO();
    $modeloBlusa = new ModeloBlusa();
    $modoProdDAO = new ModoProdDAO();
	$modoProd = new ModoProd();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
        case 'salvar':
        
            // verifica se foi enviado um imagem
            if ( isset( $_FILES[ 'imagem' ][ 'name' ] ) && $_FILES[ 'imagem' ][ 'error' ] == 0 ) {
                //echo 'Você enviou o imagem: <strong>' . $_FILES[ 'imagem' ][ 'name' ] . '</strong><br />';
                //echo 'Este imagem é do tipo: <strong > ' . $_FILES[ 'imagem' ][ 'type' ] . ' </strong ><br />';
                //echo 'Temporáriamente foi salvo em: <strong>' . $_FILES[ 'imagem' ][ 'tmp_name' ] . '</strong><br />';
                //echo 'Seu tamanho é: <strong>' . $_FILES[ 'imagem' ][ 'size' ] . '</strong> Bytes<br /><br />';
            
                $imagem_tmp = $_FILES[ 'imagem' ][ 'tmp_name' ];
                $nome = $_FILES[ 'imagem' ][ 'name' ];
            
                // Pega a extensão
                $extensao = pathinfo ( $nome, PATHINFO_EXTENSION );
            
                // Converte a extensão para minúsculo
                $extensao = strtolower ( $extensao );
            
                // Somente imagens, .jpg;.jpeg;.gif;.png
                // Aqui eu enfileiro as extensões permitidas e separo por ';'
                // Isso serve apenas para eu poder pesquisar dentro desta String
                if ( strstr ( '.jpg;.jpeg;.gif;.png', $extensao ) ) {
                    // Cria um nome único para esta imagem
                    // Evita que duplique as imagens no servidor.
                    // Evita nomes com acentos, espaços e caracteres não alfanuméricos
                    $novoNome = uniqid ( time () ) . '.' . $extensao;
            
                    // Concatena a pasta com o nome
                    $destino = 'imagens/modeloBlusas/' . $novoNome;

                    $modeloBlusa->setImagem($novoNome);
            
                    // tenta mover o imagem para o destino
                    if ( @move_uploaded_file ( $imagem_tmp, $destino ) ) {
                        //echo 'Imagem salvo com sucesso em : <strong>' . $destino . '</strong><br />';
                        //echo ' < img src = "' . $destino . '" />';
                    }
                    //else
                        //echo 'Erro ao salvar o imagem. Aparentemente você não tem permissão de escrita.<br />';
                }
                //else
                    //echo 'Você poderá enviar apenas imagems "*.jpg;*.jpeg;*.gif;*.png"<br />';
            }else if($_POST["caminho"] != 'exemploModeloBlusa.png'){
                $caminho = $_POST["caminho"];
                $modeloBlusa->setImagem($_POST["caminho"]);
                } 

                if($_POST["caminho"] == null){ 
                    $fotoNome = "exemploModeloBlusa.png";
                    $modeloBlusa->setImagem($fotoNome);
                }
            //else
                //echo 'Você não enviou nenhum imagem!';
            
                
        
            
			$modeloBlusa->setIdModeloBlusa($_POST["idModeloBlusa"]);
			$modeloBlusa->setNome($_POST["nome"]);
            $modoProd = $modoProdDAO->buscarPorId($_POST['idModoProducao']);
			$modeloBlusa->setModoProducao($modoProd);

			$resultado = $modeloBlusaDAO->salvar($modeloBlusa);		
            print_r($modeloBlusa);
			if($resultado == TRUE){
				echo "<script>location.href='../formulario/ModeloBlusaFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/ModeloBlusaFormulario.php?resultado=erro';</script>"; 			
			}
            
        	break; 

        case 'excluir':
			
			$resultado = $modeloBlusaDAO->excluirPorId($_GET["idModeloBlusa"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/ModeloBlusaTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/ModeloBlusaTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>