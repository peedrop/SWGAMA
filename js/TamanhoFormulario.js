$('#altura').mask("0000000.00", {
    reverse: true
});
$('#largura').mask("0000000.00", {
    reverse: true
});
$("#formModoProd").validate({
    rules:{
         tamanho:{
             required:true, 
         },  
         altura:{
             required:true, 
             min: 0,
         },  
         largura:{
             required:true, 
             min: 0,
         }
    }, 
    messages:{
         nome:{
             required: "Obrigatório*",
         },  
         altura:{
             required: "Obrigatório*",
             min:"Altura mínima de 0 cm*",
         },  
         largura:{
             required: "Obrigatório*",
             min:"Largura mínima de 0 cm*",
         }
    }
 });
 
 