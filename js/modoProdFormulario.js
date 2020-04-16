$('#preco').mask("0000000.00", {
    reverse: true
});
$("#formModoProd").validate({
    rules:{
         nome:{
             required:true, 
         },  
         preco:{
             required:true, 
             min: 0,
         }
    }, 
    messages:{
         nome:{
             required: "Obrigatório*",
         },  
         preco:{
             required: "Obrigatório*",
             min:"Preço mínimo de 0 reais*",
         }
    }
 });
 
 