let pontosUsuario = 0;
let pontosComputador = 0;

const gifs = {
    pedra: "../img/pedraUsu.gif",
    papel: "../img/papelUsu.gif",
    tesoura: "../img/tesouraUsu.gif"
};
const gifsPC = {
    pedra: "../img/pedraPC.gif",
    papel: "../img/papelPC.gif",
    tesoura: "../img/tesouraPC.gif"
};

document.querySelectorAll('.btn-jogo.gamer-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        const escolha = this.getAttribute('data-escolha');
        document.getElementById('modal-disputa').classList.add('active');
        document.getElementById('gif-usuario').src = gifs[escolha];
        document.getElementById('gif-computador').src = "../img/pedraPapelTesouraPC.gif";

        // Sorteia jogada do computador
        const opcoes = ['pedra', 'papel', 'tesoura'];
        const escolhaPC = opcoes[Math.floor(Math.random() * 3)];

        setTimeout(() => {
            document.getElementById('gif-computador').src = gifsPC[escolhaPC];

            // Envia o form por POST via JS (sem reload)
            const formData = new FormData();
            formData.append('escolha', escolha);
            formData.append('computador', escolhaPC);

            fetch('', { method: 'POST', body: formData })
                .then(resp => resp.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const resultado = doc.querySelector('.result').innerHTML;

                    // Atualiza placar
                    if (resultado.includes('Você venceu')) {
                        pontosUsuario++;
                    } else if (resultado.includes('Você perdeu')) {
                        pontosComputador++;
                    }
                    document.getElementById('placar-usuario').textContent = pontosUsuario;
                    document.getElementById('placar-computador').textContent = pontosComputador;

                    // Mostra resultado no modal
                    document.getElementById('resultado-modal').innerHTML = resultado;
                });
        }, 1200);
    });
});

// Botão OK fecha o modal
document.getElementById('btn-ok-modal').addEventListener('click', function () {
    document.getElementById('modal-disputa').classList.remove('active');
    document.getElementById('resultado-modal').innerHTML = '';
});