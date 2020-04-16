$("#formDespesa").validate({
    rules:{
         nome:{
             required:true, 
         }
    }, 
    messages:{
         nome:{
             required: "Obrigatório*",
         }
    }
 });
 
 