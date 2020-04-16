$('#telefone').mask("(00)00000-0000");
$("#formFornecedor").validate({
    rules:{
         nome:{
             required:true, 
             minlength: 3,
             maxlength: 100
         },  
         telefone:{
            required:true,
         },
         email:{
             required:true,
             email: true
         },
         endereco:{
            required:true,
            minlength: 3,
            maxlength: 300
         }
    }, 
    messages:{
        nome:{
            required: "Obrigatório*", 
            minlength: "Nome com no mínimo 3 caracteres*",
            maxlength: "Nome com no máximo 100 caracteres*"
        },  
        
        telefone:{
            required: "Obrigatório*",
        },
        email:{
            required: "Obrigatório*",
            email: "Digite email válido*"
        },
        endereco:{
            required: "Obrigatório*",
            minlength: "Endereço com no mínimo 3 caracteres*",
            maxlength: "Endereço com no máximo 300 caracteres*"
        }
    }
 });