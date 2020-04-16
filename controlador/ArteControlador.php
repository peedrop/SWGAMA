<?php

    require_once '../class/ArteDAO.php';
    
	$arteTesteDAO = new ArteDAO();
	$arte = new Arte();

	$operacao = $_GET["operacao"];

	switch($operacao) 
	{
		case 'salvar':
			$altura = "425";
			$largura = "500";

			echo "Altura pretendida: $altura - Largura prendida: $largura";
			echo "<br>";

			echo $_FILES['imagem']['type'];

			switch($_FILES['imagem']['type']):
				case 'image/png';
					$imagem_temporaria = imagecreatefrompng( $_FILES['imagem']['tmp_name']);

					$largura_original = imagesx($imagem_temporaria);
					$altura_original = imagesy($imagem_temporaria);

					$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
					$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);

					$imagem_redimencionada = imagecreatetruecolor($nova_largura, $nova_altura);

					imagecopyresampled($imagem_redimencionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura,
					$largura_original, $altura_original);
					
				break;
				case 'image/jpeg';
					$imagem_temporaria = imagecreatefromjpeg( $_FILES['imagem']['tmp_name']);

					$largura_original = imagesx($imagem_temporaria);
					$altura_original = imagesy($imagem_temporaria);

					$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
					$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);

					$imagem_redimencionada = imagecreatetruecolor($nova_largura, $nova_altura);

					imagecopyresampled($imagem_redimencionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura,
					$largura_original, $altura_original);

					$fotoNome = uniqid().$_FILES['imagem']['name'];
					imagejpeg($imagem_redimencionada, '../images/' . $fotoNome);
					
				break;
				case 'image/jpg';
					$imagem_temporaria = imagecreatefromjpg( $_FILES['imagem']['tmp_name']);

					$largura_original = imagesx($imagem_temporaria);
					$altura_original = imagesy($imagem_temporaria);

					$nova_largura = $largura ? $largura : floor (($largura_original / $altura_original) * $altura);
					$nova_altura = $altura ? $altura : floor (($altura_original / $largura_original) * $largura);

					$imagem_redimencionada = imagecreatetruecolor($nova_largura, $nova_altura);

					imagecopyresampled($imagem_redimencionada, $imagem_temporaria, 0, 0, 0, 0, $nova_largura, $nova_altura,
					$largura_original, $altura_original);

					$fotoNome = uniqid().$_FILES['imagem']['name'];
					imagejpg($imagem_redimencionada, '../images/' . $fotoNome);

					echo "<img scr='images/".$_FILES['imagem']['name']."'>";

					
				break;
			endswitch;

			echo "<br>";

			$arte->setIdArte($_POST["idArte"]);
			$arte->setImagem('images/' . $fotoNome);

			$resultado = $arteTesteDAO->salvar($arte);

			if($resultado == TRUE){
				echo "<script>location.href='../formulario/ArteFormulario.php?resultado=sucesso';</script>"; 
			}else{
				echo "<script>location.href='../formulario/ArteFormulario.php?resultado=erro';</script>"; 			
			}

		break; 

        case 'excluir':
			
			$resultado = $arteTesteDAO->excluirPorId($_GET["idArte"]);

			if($resultado == 1){
				echo "<script>alert('Registro excluido com sucesso !!!'); location.href='../tabela/ArteTabela.php';</script>"; 
			}else{
				echo "<script>alert('Erro ao excluir o registro'); location.href='../tabela/ArteTabela.php';</script>"; 			
			}			
        	break;         	
	}
			
?>