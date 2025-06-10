<?php
$mostrarHome = !isset($_GET['jogar']) && $_SERVER['REQUEST_METHOD'] !== 'POST';
$resultado = "Faça sua jogada!";
$status = "";
$mostrarModal = false;
$jogada = $computador = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['jogada'])) {
    $jogada = $_POST["jogada"];
    $jokenpo = ["pedra", "papel", "tesoura"];
    $computador = $jokenpo[rand(0, 2)];
    if ($jogada === $computador) {
        $resultado = "Empate! Você e o computador jogaram $jogada.";
        $status = "empate";
    } elseif (
        ($jogada === "pedra" && $computador === "tesoura") ||
        ($jogada === "papel" && $computador === "pedra") ||
        ($jogada === "tesoura" && $computador === "papel")
    ) {
        $resultado = "Você ganhou! Você jogou $jogada e o computador jogou $computador.";
        $status = "vitoria";
    } else {
        $resultado = "Você perdeu! Você jogou $jogada e o computador jogou $computador.";
        $status = "derrota";
    }
    $mostrarModal = true;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Jo-Ken-Pô</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Bungee&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../styles/styles.css">
    <style>
        .disputa-gifs {
            display: flex;
            gap: 32px;
            justify-content: center;
            align-items: center;
            margin: 18px 0 0 0;
        }

        .disputa-col {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .disputa-label {
            color: #fff;
            font-size: 1.1rem;
            margin-bottom: 8px;
            font-family: 'Bungee', Arial, sans-serif;
            text-shadow: 0 2px 8px #0008;
        }

        .gif-usuario,
        .gif-computador {
            width: 90px;
            height: 90px;
            object-fit: contain;
            background: #181828;
            border-radius: 12px;
            border: 2px solid #a259ff;
        }
    </style>
</head>

<body>
    <!-- Parallax Home -->
    <section class="parallax-section">
        <img src="../img/background_pt1.png" class="parallax-img layer-fundo" alt="Fundo">
        <img src="../img/backgroundHome_pt2.png" class="parallax-img layer-meio" alt="Meio">
        <img src="../img/backgroundHome_pt3.png" class="parallax-img layer-meio2" alt="Meio2">
        <img src="../img/backgroundHome_pt4.png" class="parallax-img layer-frente" alt="Frente">
    </section>

    <?php if ($mostrarHome): ?>
        <!-- TELA INICIAL -->
        <div class="tela-home tela-home-simples">
            <div class="topo-home">
                <h1 class="titulo-principal">JO-KEN-PO</h1>
                <p class="subtitulo-inicio">Desafie o computador no Jo-Ken-Pô! Clique em jogar.</p>
            </div>
            <form action="" method="get">
                <button class="btnJogar btnJogar-grande" type="submit" name="jogar" value="1" id="jogar">Jogar</button>
            </form>
        </div>
    <?php else: ?>
        <!-- TELA DO JOGO -->
        <section class="sessao-jogo" id="sessao-jogo">
            <div class="game-card">
                <h2 class="bungee-regular escolha-titulo" style="color:#fff;">Escolha sua jogada</h2>
                <form method="post" class="botoes-jogo" id="form-jogo" autocomplete="off">
                    <button type="submit" name="jogada" value="pedra" class="btn-jogo gamer-btn">🪨 Pedra</button>
                    <button type="submit" name="jogada" value="papel" class="btn-jogo gamer-btn">📄 Papel</button>
                    <button type="submit" name="jogada" value="tesoura" class="btn-jogo gamer-btn">✂️ Tesoura</button>
                </form>
            </div>
        </section>

        <!-- MODAL DE RESULTADO -->
        <div class="modal-disputa<?php if ($mostrarModal) echo ' active'; ?>" id="modal-disputa">
            <div class="modal-disputa-inner">
                <h2 style="color:#fff;">Resultado:</h2>
                <div class="disputa-gifs">
                    <div class="disputa-col">
                        <span class="disputa-label">Você</span>
                        <?php if ($jogada): ?>
                            <video class="gif-usuario" src="../video/<?php echo $jogada; ?>Usu.mp4" autoplay loop></video>
                        <?php endif; ?>
                    </div>
                    <div class="disputa-col">
                        <span class="disputa-label">Computador</span>
                        <?php if ($computador): ?>
                            <video class="gif-computador" src="../video/<?php echo $computador; ?>PC.mp4" autoplay loop></video>
                        <?php endif; ?>
                    </div>
                </div>
                <p class="<?php
                            if ($status === 'vitoria') echo 'texto-vitoria';
                            elseif ($status === 'derrota') echo 'texto-derrota';
                            else echo 'texto-empate';
                            ?>" style="color:#fff;"><?php echo $resultado; ?></p>
                <button type="button" class="btn-fechar-modal" id="btn-fechar-modal">JOGUE NOVAMENTE</button>
            </div>
        </div>
        <script>
            // Fecha o modal sem recarregar e permite jogar novamente
            document.addEventListener('DOMContentLoaded', function() {
                var modal = document.getElementById('modal-disputa');
                var btnFechar = document.getElementById('btn-fechar-modal');
                if (btnFechar) {
                    btnFechar.onclick = function() {
                        modal.classList.remove('active');
                    }
                }
            });
        </script>
    <?php endif; ?>
</body>

</html>