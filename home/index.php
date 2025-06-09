<?php
$resultado = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $opcoes = ['pedra', 'papel', 'tesoura'];
    $usuario = $_POST['escolha'];
    $computador = isset($_POST['computador']) ? $_POST['computador'] : $opcoes[array_rand($opcoes)];

    if ($usuario === $computador) {
        $resultado = "Empate! Ambos escolheram <b>$usuario</b>.";
    } elseif (
        ($usuario === 'pedra' && $computador === 'tesoura') ||
        ($usuario === 'papel' && $computador === 'pedra') ||
        ($usuario === 'tesoura' && $computador === 'papel')
    ) {
        $resultado = "Você venceu! $usuario vence $computador.";
    } else {
        $resultado = "Você perdeu! $computador vence $usuario.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Jo-Ken-Pô</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Fonte gamer -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/styles.css">
</head>

<body>
    <main>
        <section class="hero-bg">
            <img src="../img/background_pt1.png" class="bg-layer layer1" alt="Fundo 1">
            <img src="../img/backgroundHome_pt2.png" class="bg-layer layer2" alt="Fundo 2">
            <img src="../img/backgroundHome_pt3.png" class="bg-layer layer3" alt="Fundo 3">
            <img src="../img/backgroundHome_pt4.png" class="bg-layer layer4" alt="Fundo 4">
            <div class="hero-content">
                <h1 class="bungee-regular titulo-principal">JO-KEN-PÔ</h1>
                <p class="subtitulo">Desafie o computador no clássico Pedra, Papel ou Tesoura!</p>
                <button class="btn-jogue-agora-rgb" onclick="document.getElementById('sessao-jogo').scrollIntoView({ behavior: 'smooth' })">JOGUE AGORA</button>
            </div>
        </section>

        <section class="sessao-jogo" id="sessao-jogo">

            <div class="placar-externo">
                <div class="placar-caixa usuario">
                    <span class="placar-nome">Você</span>
                    <span id="placar-usuario" class="placar-pontos">0</span>
                </div>
                <span class="placar-x">x</span>
                <div class="placar-caixa computador">
                    <span class="placar-nome">Computador</span>
                    <span id="placar-computador" class="placar-pontos">0</span>
                </div>
            </div>

            <div class="game-card">
                <h2 class="bungee-regular escolha-titulo">Escolha sua jogada</h2>
                <form method="post" class="botoes-jogo" id="form-jogo" autocomplete="off">
                    <button type="button" data-escolha="pedra" class="btn-jogo gamer-btn">🪨 Pedra</button>
                    <button type="button" data-escolha="papel" class="btn-jogo gamer-btn">📄 Papel</button>
                    <button type="button" data-escolha="tesoura" class="btn-jogo gamer-btn">✂️ Tesoura</button>
                </form>
                <div class="result">
                    <?php echo $resultado; ?>
                </div>
            </div>

            <!-- Modal de disputa -->
            <div class="modal-disputa" id="modal-disputa">
                <div class="modal-disputa-inner">
                    <div class="disputa-titulos">
                        <span>Você</span>
                        <span>Computador</span>
                    </div>
                    <div class="disputa-gifs">
                        <img id="gif-usuario" src="../img/pedraPapelTesouraUsu.gif" alt="Sua escolha">
                        <img id="gif-computador" src="../img/pedraPapelTesouraPC.gif" alt="Escolha do computador">
                    </div>
                    <button id="btn-ok-modal" class="btn-jogo gamer-btn" style="margin-top:28px;min-width:100px;">OK</button>
                    <div id="resultado-modal" style="margin-top:18px;color:#fff;font-size:1.1rem;"></div>
                </div>
            </div>
        </section>
    </main>
    <script>
        let pontosUsuario = 0;
        let pontosComputador = 0;

        const gifsUsuario = {
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
            btn.addEventListener('click', function() {
                const escolha = this.getAttribute('data-escolha');
                document.getElementById('modal-disputa').classList.add('active');
                document.getElementById('gif-usuario').src = gifsUsuario[escolha];
                document.getElementById('gif-computador').src = "../img/pedraPapelTesouraPC.gif";

                // Sorteia jogada do computador
                const opcoes = ['pedra', 'papel', 'tesoura'];
                const escolhaPC = opcoes[Math.floor(Math.random() * 3)];

                setTimeout(() => {
                    document.getElementById('gif-computador').src = gifsPC[escolhaPC];

                    // Envia o form por POST via JS (sem reload)
                    const formData = new FormData();
                    formData.append('escolha', escolha);

                    fetch('', {
                            method: 'POST',
                            body: formData
                        })
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
        document.getElementById('btn-ok-modal').addEventListener('click', function() {
            document.getElementById('modal-disputa').classList.remove('active');
            document.getElementById('resultado-modal').innerHTML = '';
        });
    </script>
</body>

</html>