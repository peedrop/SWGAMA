<?php	
    require_once '../class/EstoqueDAO.php';
    require_once '../class/BlusaDAO.php';
    require_once '../class/BlusaEstoqueDAO.php';
    require_once '../class/BlusaEstoque.php';
    session_start();
    if(isset($_SESSION['USUARIO'])){
	}else{
		echo "<script>alert('É preciso estar logado para acessar essa página!');location.href='../formulario/Login.php';</script>";
    }
    
    $estoque = new Estoque();

    if(isset($_GET["operacao"])){
        $operacao = $_GET["operacao"];
    }
    $resultado = '';
    if(isset($_GET["resultado"])){
        $resultado = $_GET["resultado"];
    }

    echo "<script>  var listaBlusas = new Array(); </script>";
    $titulo = "Entrada de estoque";

    if(isset($_GET["idEstoque"])){
        
        $idEstoque = $_GET["idEstoque"];

        $estoqueDAO = new EstoqueDAO();
        $estoque = $estoqueDAO->buscarPorId($idEstoque);

        $blusaEstoqueDAO = new BlusaEstoqueDAO();
        $teste = new BlusaEstoque();

        $blusasEstoque = $blusaEstoqueDAO->listarPorEntrada($idEstoque);
        for($i = 0; $i <  count($blusasEstoque); $i++){
            //echo $blusasEstoque[$i]->getBlusa()->getNome();
            echo $teste->criarObjetoJS($blusasEstoque[$i]);
            //echo "<script> alert(blusaEstoque['nome']); </script>";
            echo "<script> listaBlusas.push(blusaEstoque); </script>";
        }

        $nome = $estoque->getData();
        
        $titulo = "Editando entrada de estoque: $nome";
    }		
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <title>Entrada de estoque</title>
        <?php 
            include_once("../blocosRepetidos/cssPadrao.php");  	
        ?>	
    </head>

    <body>	
        <div class="wrapper">
            <?php 
                include_once("../blocosRepetidos/sidebar.php");  	
            ?>
            <div class="main-panel" id="main-panel">
                <?php 
                    include_once("../blocosRepetidos/navbar.php");  	
                ?>
                <div class="panel-header panel-header-sm">
                </div>
                <div class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="col-md-3 float-right">
                                    <a class="btn btn-light btn-round float-right" href="../tabela/EstoqueTabela.php"><< Voltar</a>
                                </div>
                                <div class="card-header">
                                    <h5 class="title"><?php echo $titulo ?></h5>
                                </div>
                                <div class="card-body">
                                    <?php 
                                        if ($resultado == 'sucesso'){
                                            include_once("../blocosRepetidos/alertSucesso.php");  
                                        }
                                        if ($resultado == 'erro'){
                                            include_once("../blocosRepetidos/alertErro.php");  
                                        }
                                    ?>	
                                    <form id="formEstoque" action="../controlador/EstoqueControlador.php?operacao=salvar" method="post">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Data</label>
                                                    <input type="hidden" name="idEstoque" id="idEstoque" value="<?php echo $estoque->getIdEstoque() ?>" >
                                                    <input type="date" class="form-control" id="data" name="data" 
                                                    value="<?php echo $estoque->getData() ?>" placeholder="" required>
                                                    <input type="hidden" name="tipo" id="tipo" value="ENTRADA">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="blusas">Blusa</label>	
                                                    <select id="blusas" name="blusas" class="form-control">	
                                                    <option disabled selected value="">Selecione uma blusa</option>     					  
                                                        <?php
                                                            $blusaDAO = new BlusaDAO();
                                                            $lista = $blusaDAO->listar();

                                                            if($lista == null){
                                                                echo "<option disabled selected value=''>Não há blusas cadastradas</option>";     
                                                            }
                                                            foreach($lista as $blusa){	
                                                                echo "<option 
                                                                        value='{$blusa->getIdBlusa()}'>{$blusa->getNome()}
                                                                        </option>";
                                                            }
                                                        ?>	
                                                    </select>	
                                                </div>		
                                            </div>
                                            <div class="col-md-3 ">
                                                <div class="form-group">
                                                    <label>Quantidade</label>
                                                    <input type="number" class="form-control" id="qtd" name="qtd" 
                                                    value="" placeholder="0">
                                                </div>
                                            </div>
                                            <div class="col-md-2" style="margin-top: 0.5%;">
                                                <a href="#" class="btn btn-success btn-round mt-3" title="Adicionar blusa" id="add"> Adicionar</a>
                                            </div>
                                        </div>

                                        <div class="col-md-12" style="margin-top: 50px">
                                            <table class="table" id="tabelaBlusas" style="display:none">
                                                <thead>
                                                    <th>Produto</th>
                                                    <th>Quantidade</th>
                                                    <th></th>
                                                </thead>
                                                <tbody id="tabela">
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="blusasDiv"></div>
                                        <div class="quantidadesDiv"></div>
                                        <div class="excluidosDiv"></div>

                                        <button type="reset" class="btn btn-danger btn-round mt-3">Cancelar</button>
                                        <button type="submit" class="btn btn-success btn-round mt-3" id="salvar" disabled>Salvar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php 
                    include_once("../blocosRepetidos/footer.php");  	
                ?>
            </div>
        </div>
        <?php 
            include_once("../blocosRepetidos/jsPadrao.php");  	
        ?>
        <!-- script para formar linhas da tabela -->
        <script>
            var blusas = new Array();
            var quantidades = new Array();
            var objeto = new Array();  
            var indice = 0;
            var linhasExcluidas = new Array();
            var existe  = false;

            $(document).ready(function(){
                if(listaBlusas != ''){
                    for(var i = 0; i < listaBlusas.length; i++) {
                        $("#tabelaBlusas").show();
                        $('#tabela').append('<tr id='+indice+'><td>' + listaBlusas[i].nome + '</td><td>'+ listaBlusas[i].qtd + '</td><td> <btn onclick="remove('+indice+')" class="btn btn-danger" title="Remover blusa">Excluir</a> </td></tr>');
                            
                        var blus = {
                            idBlusa: parseInt(listaBlusas[i].id),
                            idBlusaEstoque: parseInt(listaBlusas[i].idBlusaEstoque),
                            ind: indice,
                            qtd: parseInt(listaBlusas[i].qtd)
                        };  
                        objeto.push(blus);
                        indice++;
                    }
                }
            });
            function funcaoRecursiva(i){
                
            }
            
            $('#add').click(function () {
                if ($('#blusas').val() != null) {
                    id = $('#blusas option:selected').val();
                    for(var i=0; i< objeto.length; i++) {
                        if(objeto[i] != null && objeto[i].idBlusa == id){
                            bootbox.alert("Essa blusa já existe na tabela!");
                            existe = true;
                            $('#qtd').val('');
                            $('#blusas').val('');
                            break;
                        }
                    }
                    if(!existe){
                        if ($('#qtd').val() > 0) {
                            id = $('#blusas option:selected').val();
                            nome = $('#blusas option:selected').text();
                            qtd = $('#qtd').val();

                            $('#tabela').append('<tr id=' + indice + '><td>' + nome + '</td><td>' + qtd + '</td><td> <btn onclick="remove(' + indice + ')" class="btn btn-danger" title="Remover blusa">Excluir</td></tr>');
                            $("#tabelaBlusas").show();

                            var blusa = {
                                idBlusa: parseInt(id),
                                idBlusaEstoque: 0,
                                ind: indice,
                                qtd: parseInt(qtd)
                            };  

                            objeto.push(blusa);
                            indice++;
                        
                            $('#qtd').val('');
                            $('#blusas').val('');
                            document.getElementById('salvar').disabled = false;
                        
                            document.getElementById('tipo').disabled = true;
                        } else if($('#qtd').val() == ''){
                            bootbox.alert("Informe a quantidade de blusas");
                        } else{
                            bootbox.alert("Quantidade inválida");
                        }
                    } 
                } else {
                    bootbox.alert("Selecione uma blusa");
                }
            });

            function remove(id) {
                bootbox.confirm({ 
                    size: "small",
                    buttons: {
                    confirm: {
                            label: 'Sim',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'Não',
                            className: 'btn-danger'
                        }
                    },
                    message: "Deseja remover esta blusa?",
                    callback: function(result){ 
                        if(result){
                            for(var i=0; i<objeto.length; i++) {
                                if(objeto[i] != null && objeto[i].ind == id){
                                    if(objeto[i].idBlusa != 0){
                                        linhasExcluidas.push(objeto[i].idBlusa);
                                        $('.linhasExcluidas').val(linhasExcluidas);
                                        console.log(linhasExcluidas);
                                    }
                                    $('#' + id).remove();
                                    objeto.splice(i, 1);
                                    document.getElementById('salvar').disabled = false;
                                    break;
                                }
                            }
                            if(objeto[0] == null){
                                $("#tabelaBlusas").hide();
                            } 
                        }
                    }
                })
            }

            $('form').submit(function(){
                $('.blusasDiv').empty();
                $('.quantidadesDiv').empty();
                $('.linhasExcluidas').empty();
                for (i = 0; i < objeto.length; i++) { 
                    $('.blusasDiv').append("<input type='hidden' name='blusas[]' value='"+objeto[i].idBlusa+"'/>");
                    $('.quantidadesDiv').append("<input type='hidden' name='quantidades[]' value='"+objeto[i].qtd+"'/>");
                };
                for(i = 0; i < linhasExcluidas.length; i++){
                    $('.excluidosDiv').append("<input type='hidden' name='linhasExcluidas[]' value='"+linhasExcluidas[i]+"'/>");
                } 
            }); 

        </script>
        <!-- Outros JS-->
        <script type="text/javascript" src="../js/"></script>
    </body>
</html>
