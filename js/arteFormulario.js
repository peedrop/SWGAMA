$("#formModeloBlusa").validate({
    rules:{
         imagem:{
             required:true
         }
    }, 
    messages:{
         imagem:{
             required: "Obrigatório*"
         }
    }
 });