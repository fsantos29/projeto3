<?php
session_start();

$acessoNegado = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];


    $db = new PDO("mysql:host=localhost;dbname=exercicio", "usuario", "senha123");

    $query = $db->prepare("SELECT nome, email FROM usuario WHERE email = ? AND senha = ? ");
    $query->bindParam(1, $email);
    $query->bindParam(2, $senha);

    if ($query->execute()) {
        if ($query->rowCount() > 0) {
            $l = $query->fetch(PDO::FETCH_OBJ);
            $_SESSION['nome'] = $l->nome;
            $_SESSION['email'] = $l->email;;
            header('location:consulta_cpf.php');
        }
    }

    $acessoNegado = true;
}

?>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Principal CSS do Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos customizados para esse template -->
    <link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin" method="post">
        <h1 class="h3 mb-3 font-weight-normal">Sistema de consulta CPF</h1>

        <?php if ($acessoNegado) { ?>
            <h5 class="mb-3 font-weight-normal text-danger">Usuário ou senha invalidos!</h5>
        <?php } ?>

        <label for="email" class="sr-only">Endereço de email</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="Seu email" required="" autofocus="">
        <label for="senha" class="sr-only">Senha</label>
        <input type="password" id="senha" name="senha" class="form-control" placeholder="Senha" required="">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
        <p class="mt-5 mb-3 text-muted">© 2021</p>
    </form>

</body>

</html>