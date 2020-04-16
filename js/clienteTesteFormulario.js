$("#formClienteTeste").validate({
   rules:{
        nome:{
            required:true, 
        },  
        idade:{
            required:true, 
            min: 1,
            max: 150
        }
   }, 
   messages:{
        nome:{
            required: "Obrigatório*",
        },  
        idade:{
            required: "Obrigatório*",
            min:"Idade mínima de 1 ano*",
            max:"Idade máxima de 150 anos*"
        }
   }
});

