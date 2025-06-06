<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Jo-Ken-Pô</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>

<body>
    <div class="parallax">
        <img src="/img/background_pt1.png" class="parallax-layer layer-fundo" alt="Fundo">
        <img src="/img/background_pt2.png" class="parallax-layer layer-meio" alt="Meio">
        <img src="/img/background_pt3.png" class="parallax-layer layer-frente" alt="Meio2">
        <img src="/img/background_pt4.png" class="parallax-layer layer-frente" alt="Frente">

    </div>
    <div class="container">
        <h1>Jo-Ken-Pô</h1>
        <form method="post">
            <button type="submit" name="escolha" value="pedra">Pedra</button>
            <button type="submit" name="escolha" value="papel">Papel</button>
            <button type="submit" name="escolha" value="tesoura">Tesoura</button>
        </form>

        <div class="result">
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $opcoes = ['pedra', 'papel', 'tesoura'];
                $usuario = $_POST['escolha'];
                $computador = $opcoes[array_rand($opcoes)];

                if ($usuario === $computador) {
                    echo "Empate! Ambos escolheram <b>$usuario</b>.";
                } elseif (
                    ($usuario === 'pedra' && $computador === 'tesoura') ||
                    ($usuario === 'papel' && $computador === 'pedra') ||
                    ($usuario === 'tesoura' && $computador === 'papel')
                ) {
                    echo "Você venceu! $usuario vence $computador.";
                } else {
                    echo "Você perdeu! $computador vence $usuario.";
                }
            }
            ?>
        </div>
    </div>
</body>

</html>