$("#formLogin").validate({
    rules: {
        email: {
            required: true,
        },
        senha: {
            required: true,
        }
    },
    messages: {
        email: {
            required: "Obrigatório*",
        },
        senha: {
            required: "Obrigatório*",
        }
    }
});
