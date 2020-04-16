
function limpa_formulário_cep() {
    // Limpa valores do formulário de cep.
    $("#rua").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#estado").val("");
    $("#ibge").val("");
}
var endereco = new Array(3);
endereco[0] = "";
endereco[1] = "";
endereco[2] = "";
$("#numero").blur(function() {
    endereco[0] = "";
    var numero = $(this).val();
    if (numero != ""){
        endereco[0] = "    Número: " + numero;
        juntarEndereco();
        //$("#endereco").val(endereco);
    }
});
$("#complemento").blur(function() {
    endereco[1] = "";
    var complemento = $(this).val();
    if (complemento != ""){
        endereco[1] = "    Complemento: " + complemento;
        juntarEndereco();
        //$("#endereco").val(endereco);
    }
});
//Quando o campo cep perde o foco.
$("#cep").blur(function() {

    //Nova variável "cep" somente com dígitos.
    var cep = $(this).val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if(validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            $("#rua").val("...");
            $("#bairro").val("...");
            $("#cidade").val("...");
            $("#estado").val("...");
            $("#ibge").val("...");

            //Consulta o webservice viacep.com.br/
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    endereco[2] = "Cidade: " + dados.localidade + "-" + dados.uf + "    ";
                    endereco[2] += "Bairro: " + dados.bairro + "    ";
                    endereco[2] += "Logradouro: " + dados.logradouro;
                    juntarEndereco();
                    //$("#endereco").val(endereco);
                    $("#rua").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#estado").val(dados.uf);
                    $("#ibge").val(dados.ibge);
                } //end if.
                else {
                    //CEP pesquisado não foi encontrado.
                    limpa_formulário_cep();
                    $("#cep").val("CEP não encontrado.");
                    //alert("CEP não encontrado.");
                }
            });
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            $("#cep").val("Formato de CEP inválido.");
            //alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
});
function juntarEndereco(){
    var abacate = endereco[2];
    abacate += endereco[0];
    abacate += endereco[1];
    $("#endereco").val(abacate);
}
$(document).ready(function() {
    var tipoPessoa = document.getElementById('pegarTipoPessoa').value;

    if (tipoPessoa == "Pessoa Física"){
        botaoPessoaFisica();
    }else{
        if(tipoPessoa == "Pessoa Jurídica"){
            botaoPessoaJuridica();
        }
    }

    $("#pessoaFisica").click(function (){
        botaoPessoaFisica();
    });

    $("#pessoaJuridica").click(function (){
        botaoPessoaJuridica();
    });
});
function botaoPessoaFisica(){
    // desabilita botão pessoa juridica
    document.getElementById('pessoaJuridica').className = 'btn btn-outline-info';
    // habilita botão pessoa fisica
    document.getElementById('pessoaFisica').className = 'btn btn-info';
    // esconde input cnpj
    document.getElementById('opcaoCnpj').className = 'd-none';
    // mostra input cpf
    document.getElementById('opcaoCpf').className = 'form-group';
    //$("#cpf").prop("disabled", false);
}
function botaoPessoaJuridica(){
    // desabilita botão pessoa fisica
    document.getElementById('pessoaFisica').className = 'btn btn-outline-info';
    // habilita botão pessoa juridica
    document.getElementById('pessoaJuridica').className = 'btn btn-info';
    // esconde input cpf
    document.getElementById('opcaoCpf').className = 'd-none';
    // mostra input cnpj
    document.getElementById('opcaoCnpj').className = 'form-group';
    //$("#cpf").prop("disabled", true);
}

$('#telefone').mask("(00)00000-0000");
$('#cep').mask("00.000-000", {
    reverse: true
});
$('#cpf').mask("000.000.000-00", {
    reverse: true
});
$('#cnpj').mask("00.000.000/0000-00", {
    reverse: true
});

$("#formCliente").validate({
    rules:{
         nome:{
             required:true, 
             minlength: 3,
             maxlength: 100
         },  
         email:{
             required:true,
         },
         cpf:{
            required:true,
            cpf: {
                cpf: true,
                required: true
            },
            remote: {
                url: "../controlador/ClienteControlador.php?operacao=verificarCpf&idCliente=" + $("#idCliente").val(),
                type: "post",
                data: {
                    login: function () {
                        return $("#cpf").val();
                    }
                }
            }
         },
         cnpj:{
            required:true,
            cnpj: {
                cpf: true,
                required: true
            },
            remote: {
                url: "../controlador/ClienteControlador.php?operacao=verificarCnpj&idCliente=" + $("#idCliente").val(),
                type: "post",
                data: {
                    login: function () {
                        return $("#cnpj").val();
                    }
                }
            }
         },
         dataNascimento:{
            required:true,
         },
         telefone:{
            required:true,
         },
         endereco:{
            required:true,
            minlength: 3,
            maxlength: 500
         }
    }, 
    messages:{
        nome:{
            required: "Obrigatório*", 
            minlength: "Nome com no mínimo 3 caracteres*",
            maxlength: "Nome com no máximo 100 caracteres*"

        },  
        email:{
            required: "Obrigatório*",
        },
        cpf:{
            required: "Obrigatório*",
            cpf: "CPF inválido*",
            remote: "CPF já cadastrado*"
        },
        cnpj:{
            required: "Obrigatório*",
            cpf: "CNPJ inválido*",
            remote: "CNPJ já cadastrado*"
        },
        dataNascimento:{
            required: "Obrigatório*",
        },
        telefone:{
            required: "Obrigatório*",
        },
        endereco:{
            required: "Obrigatório*",
            minlength: "Endereço com no mínimo 3 caracteres*",
            maxlength: "Endereço com no máximo 500 caracteres*"
        }
    }
 });
 jQuery.validator.addMethod("cpf", function (value, element) {
    value = jQuery.trim(value);

    value = value.replace('.', '');
    value = value.replace('.', '');
    cpf = value.replace('-', '');
    while (cpf.length < 11) cpf = "0" + cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i = 0; i < 11; i++) {
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) {
        a[9] = 0
    } else {
        a[9] = 11 - x
    }
    b = 0;
    c = 11;
    for (y = 0; y < 10; y++) b += (a[y] * c--);
    if ((x = b % 11) < 2) {
        a[10] = 0;
    } else {
        a[10] = 11 - x;
    }

    var retorno = true;
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) retorno = false;

    return this.optional(element) || retorno;

}, "CPF inválido*");
jQuery.validator.addMethod("cnpj", function (value, element) {

    var numeros, digitos, soma, i, resultado, pos, tamanho, digitos_iguais;
    if (value.length == 0) {
        return false;
    }

    value = value.replace(/\D+/g, '');
    digitos_iguais = 1;

    for (i = 0; i < value.length - 1; i++)
        if (value.charAt(i) != value.charAt(i + 1)) {
            digitos_iguais = 0;
            break;
        }
    if (digitos_iguais)
        return false;

    tamanho = value.length - 2;
    numeros = value.substring(0, tamanho);
    digitos = value.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0)) {
        return false;
    }
    tamanho = tamanho + 1;
    numeros = value.substring(0, tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
        soma += numeros.charAt(tamanho - i) * pos--;
        if (pos < 2)
            pos = 9;
    }

    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;

    return (resultado == digitos.charAt(1));
}, "CNPJ inválido*");