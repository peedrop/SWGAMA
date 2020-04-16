
$("#formUsuario").validate({
    rules:{
         nome:{
             required:true, 
             minlength: 2,
             maxlength: 100
         },  
         email:{
             required:true, 
         },  
         senha:{
             required:true, 
             minlength: 4
         }
    }, 
    messages:{
         nome:{
             required: "Obrigatório*",
             minlength: "Nome com no mínimo 2 caracteres*",
             maxlength: "Nome com no máximo 100 caracteres*"
         },  
         email:{
             required: "Obrigatório*",
         },  
         senha:{
             required: "Obrigatório*",
             minlength: "Senha com no mínimo 4 caracteres*"
         }
    }
 });
 
 