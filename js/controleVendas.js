var blusas = [];


document.cookie = "blusas=; path=/";
var valorTotalVenda = 0;

function addBlusa(){
    var blusa = document.getElementById('idBlusa').value;
    var vetor = blusa.split("/-/");
    var idBlusa = vetor[0];
    var nomeBlusa = vetor[1];
    var valorBlusa = vetor[2];
    var qtd = document.getElementById('qtd').value;
    var valorTotal = parseInt(valorBlusa) * parseInt(qtd); 
    
    var blusa = JSON.stringify({
        idBlusa   : idBlusa,
        nome: '0',
        gola: '0',
        malha: '0',
        producao: '0',
        tamanho: '0',
        qtd     : qtd,
        valor: '0',
        comentario: '0',
        status: 'CADASTRADA'
    });


    blusas.push(blusa);
    valorTotalVenda = valorTotalVenda + valorTotal;
    document.getElementById('valorTotal').value = valorTotalVenda;

    document.cookie = "blusas="+JSON.stringify(blusas)+"; path=/";

    $("#tabelaBlusas").show();
    
    $('#tabela').append(`
        <tr>
            <td>
                `+nomeBlusa+`
            </td>
            <td>
                `+valorBlusa+`
            </td>
            <td>
                `+qtd+`
            </td>
            <td>
                `+valorTotal+`
            </td>
            <td>
                <button onclick="removerBlusa()" class="btn btn-danger">Excluir</button>
            </td>  
        </tr>
    `);  
    
    $('#idBlusa').val('');
    $('#qtd').val('');
    console.log(blusas);
}

function addBlusaCriada(){
    var nomeBlusa = document.getElementById('nmBlusa').value;
    var golaBlusa = document.getElementById('idGola').value;
    var malhaBlusa = document.getElementById('idMalha').value;
    var producaoBlusa = document.getElementById('idModoProd').value;
    var tamanhoBlusa = document.getElementById('idTamanho').value;
    var qtdBlusa = document.getElementById('qtdBlusa').value;
    var valorBlusa = document.getElementById('valorBlusa').value;
    var comentarioBlusa = document.getElementById('comentario').value;

    
    var valorTotal = parseInt(valorBlusa) * parseInt(qtdBlusa); 
    
    var blusa = JSON.stringify({
        idBlusa   : 0,
        nome: nomeBlusa,
        gola : golaBlusa,
        malha: malhaBlusa,
        producao: producaoBlusa,
        tamanho: tamanhoBlusa,
        qtd: qtdBlusa,
        valor: valorBlusa,
        comentario: comentarioBlusa,
        status: 'ORCAMENTO'
    });

    blusas.push(blusa);

    valorTotalVenda = valorTotalVenda + valorTotal;
    document.getElementById('valorTotal').value = valorTotalVenda;

    document.cookie = "blusas="+JSON.stringify(blusas)+"; path=/";

    $("#tabelaBlusas").show();
    
    $('#tabela').append(`
        <tr>
            <td>
                Blusa `+nomeBlusa+` 
            </td>
            <td>
                `+valorBlusa+`
            </td>
            <td>
                `+qtdBlusa+`
            </td>
            <td>
                `+valorTotal+`
            </td>
            <td>
                <button onclick="removerBlusa()" class="btn btn-danger">Excluir</button>
            </td>  
        </tr>
    `);  
                
    $('#nmBlusa').val('');
    $('#idGola').val('');
    $('#idMalha').val('');
    $('#idModoProd').val('');
    $('#idTamanho').val('');
    $('#qtdBlusa').val('');
    $('#valorBlusa').val('');
    $('#comentario').val('');
    console.log(blusas);
}


let desconto = document.getElementById("desconto");

desconto.onblur = function(){
   var valorComDesconto = valorTotalVenda;
   var desc = document.getElementById('desconto').value;
   if(valorTotalVenda >= desc){
       valorComDesconto = valorTotalVenda - (valorTotalVenda * (desc/100));
   }
   document.getElementById('valorTotal').value = valorComDesconto;
}
