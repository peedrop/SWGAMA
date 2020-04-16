$("#formTipoFunc").validate({
    rules:{
         descricao:{
             required:true, 
             minlength: 3,
             maxlength: 45
         },  
         permissao:{
             required:true
         }
    }, 
    messages:{
        descricao:{
             required: "Obrigatório*",
             minlength: "O número mínimo de caracteres é 3",
             maxlength: "O número máximo de caracteres é 45"
         },  
         permissao:{
             required: "Obrigatório*"
         }
    }
 });
 
 