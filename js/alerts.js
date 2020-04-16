$().ready(function() {
	setTimeout(function () {
		$('#sucesso').hide(); // "sucesso" é o id do elemento que seja manipular.
    }, 2500); // O valor é representado em milisegundos.
    setTimeout(function () {
		$('#erro').hide(); // "erro" é o id do elemento que seja manipular.
	}, 4000); // O valor é representado em milisegundos.
});