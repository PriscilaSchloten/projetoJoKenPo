const gifs = {
    pedra: "../video/papelUsu.mp4",
    papel: "..video/pedraUsu.mp4",
    tesoura: "/video/tesouraUsu.mp4"
};
const gifsPC = {
    pedra: "/video/pedraPC.gif",
    papel: "/video/papelPC.gif",
    tesoura: "/video/tesouraPC.gif"
};

document.querySelectorAll('.btn-jogo.gamer-btn').forEach(btn => {
    btn.addEventListener('click', function (event) {
        event.preventDefault();

        const escolha = this.getAttribute('data-escolha');
        document.getElementById('modal-disputa').classList.add('active');
        document.getElementById('gif-usuario').src = gifs[escolha];

        const opcoes = ['pedra', 'papel', 'tesoura'];
        const escolhaPC = opcoes[Math.floor(Math.random() * 3)];
        document.getElementById('gif-computador').src = "/video/pedraPC.gif";

        setTimeout(() => {
            document.getElementById('gif-computador').src = gifsPC[escolhaPC];

            const formData = new FormData();
            formData.append('escolha', escolha);
            formData.append('computador', escolhaPC);

            fetch('', { method: 'POST', body: formData })
                .then(resp => resp.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const resultado = doc.querySelector('.result') ? doc.querySelector('.result').innerHTML : '';
                    document.getElementById('resultado-modal').innerHTML = resultado;
                });
        }, 1200);
    });
});

document.getElementById('btn-ok-modal').addEventListener('click', function () {
    document.getElementById('modal-disputa').classList.remove('active');
    document.getElementById('resultado-modal').innerHTML = '';
});