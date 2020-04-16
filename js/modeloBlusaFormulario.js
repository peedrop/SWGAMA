
$('#preco').mask("0000000.00", {
    reverse: true
});
$("#formModeloBlusa").validate({
    rules:{
         nome:{
             required:true, 
             minlength: 3,
             maxlength: 200
         },  
         preco:{
             required:true, 
             min: 0
         }
    }, 
    messages:{
         nome:{
             required: "Obrigatório*",
             minlength: "Nome com no mínimo 3 caracteres*",
             maxlength: "Nome com no máximo 200 caracteres*"
         },  
         preco:{
             required: "Obrigatório*",
             min:"Preço mínimo de 0 reais*"
         }
    }
 });