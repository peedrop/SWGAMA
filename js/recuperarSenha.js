$("#formRecuSenha").validate({
    rules: {
        email: {
            required: true,
            email: true,
        }
    },
    messages: {
        email: {
            required: "Obrigatório*",
            email: "E-mail inválido*",
        }
    }
});
