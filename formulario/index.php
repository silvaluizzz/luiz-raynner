<?php
include "config.php";

// Cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = $_POST["senha"];
    $mensagem = trim($_POST["mensagem"]);

    // Validação
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Preencha todos os campos obrigatórios!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Email inválido!";
    } elseif (strlen($senha) < 6) {
        echo "Senha muito curta!";
    } else {

        // Criptografia da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Prepared statement (ANTI SQL INJECTION)
        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, mensagem) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $senhaHash, $mensagem);

        if ($stmt->execute()) {
            echo "Cadastro realizado!";
        } else {
            echo "Erro ao salvar.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formulário Seguro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Cadastro</h2>

    <form method="POST" id="form">
        <input type="text" name="nome" placeholder="Nome" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <textarea name="mensagem" placeholder="Mensagem"></textarea>
        <button type="submit">Enviar</button>
    </form>

    <h2>Histórico</h2>
    <ul>
        <?php
        $result = $conn->query("SELECT nome, email, senha FROM usuarios");

        while ($row = $result->fetch_assoc()) {
            echo "<li>{$row['nome']} - {$row['email']} - {$row['senha']}</li>";
        }
        ?>
    </ul>
</div>

<script src="script.js"></script>
</body>
</html>