const $ = document.querySelector.bind(document);

const previewImg = $('#imagemTagImg');
const fileChooser = $('#imagem');
const fileButton = $('#botaoImagem');

fileButton.onclick = () => fileChooser.click();

fileChooser.onchange = e => {
    const fileToUpload = e.target.files.item(0);
    const reader = new FileReader();
    reader.onload = e => previewImg.src = e.target.result;
    reader.readAsDataURL(fileToUpload);
};
function limpar() {
    document.getElementById('imagemTagImg').src = "exemploModeloBlusa.png";
}