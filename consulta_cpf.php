<?php
session_start();

if (!isset($_SESSION['nome'])) {
    header('location:login.php');
}

$nome = $_SESSION['nome'];
$email_representante = $_SESSION['email'];

$cpf = '';
$nomeCli = '';
$sobrenome = '';
$email = '';
$endereco = '';
$cidade = '';
$estado = '';
$cep = '';
$tipo_op = 'c'; //cadastro

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $db = new PDO("mysql:host=localhost;dbname=exercicio", "usuario", "senha123");

    if (isset($_POST['tipo_op'])) { //cadastro ou edição
        if ($_POST['tipo_op'] == 'c') {

            $query = $db->prepare("INSERT INTO `cliente` (`cpf`, `nome`, `sobrenome`, `email`,
                                         `endereco`, `cidade`, `estado`, `cep`, `usr_representante`) 
                                    VALUES (?,?,?,?,?,?,?,?,?)");
        } else if ($_POST['tipo_op'] == 'e') {
            $query = $db->prepare("UPDATE `cliente` SET `cpf`=?, `nome`=?, `sobrenome`=?, `email`=?, `endereco`=?, `cidade`=?, `estado`=?, `cep`=?, `usr_representante`=? WHERE  `cpf`=? AND `usr_representante`=?");
        }
        $query->bindParam(1, $_POST['cpf']);
        $query->bindParam(2, $_POST['nome']);
        $query->bindParam(3, $_POST['sobrenome']);
        $query->bindParam(4, $_POST['email']);
        $query->bindParam(5, $_POST['endereco']);
        $query->bindParam(6, $_POST['cidade']);
        $query->bindParam(7, $_POST['estado']);
        $query->bindParam(8, $_POST['cep']);
        $query->bindParam(9, $email_representante);
        if ($_POST['tipo_op'] == 'e') {
            $query->bindParam(10, $_POST['cpf']);
            $query->bindParam(11, $email_representante);
        }
        if ($query->execute()) {
            $_SESSION['msg_alteracao'] = "  <div class='alert alert-success' role='alert'>
                                                    Cliente " . (($_POST['tipo_op'] == 'c') ? "cadastrado" : "editado") . " com sucesso!
                                                </div>";
            header('location:consulta_cpf.php');
            die;
        }

        $_SESSION['msg_alteracao'] = "  <div class='alert alert-danger' role='alert'>
                                            Erro ao " . (($_POST['tipo_op'] == 'c') ? "cadastrar" : "editar") . " cliente!
                                        </div>";

        header('location:consulta_cpf.php');
        die;

        $consultaFalhou = false;
    } else { //consulta
        $consultaFalhou = true;

        $cpf = $_POST['cpf'];

        $query = $db->prepare("SELECT * FROM cliente WHERE cpf = ? AND usr_representante = ?");
        $query->bindParam(1, $cpf);
        $query->bindParam(2, $email_representante);

        if ($query->execute()) {
            if ($query->rowCount() > 0) {
                $l = $query->fetch(PDO::FETCH_OBJ);
                $cpf = $l->cpf;
                $nomeCli = $l->nome;
                $sobrenome = $l->sobrenome;
                $email = $l->email;
                $endereco = $l->endereco;
                $cidade = $l->cidade;
                $estado = $l->estado;
                $cep = $l->cep;
                $tipo_op = 'e'; //edicao
                $consultaFalhou = false;
            }
        }
    }
} else {
    $consultaFalhou = false;
}

?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Consulta Cliente</title>


    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
        <h5 class="my-0 mr-md-auto font-weight-normal">Bem vindo <?php echo $nome ?></h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="consulta_cpf.php">Consultar Cliente</a>
        </nav>
        <a class="btn btn-outline-primary" href="login.php">Sair do Sistema</a>
    </div>

    <div class="container">
        <div class="py-5 text-center">
            <h2>Consulta cliente</h2>
            <p class="lead">Digite um CPF abaixo para pesquisar os dados de um cliente.</p>

            <div class="row justify-content-md-center">
                <div class="col-md-5">
                    <form method="post">
                        <div class="mb-3">
                            <input type="cpf" class="form-control" id="cpf" name="cpf" placeholder="___.___.___-__">
                        </div>

                        <button class="btn btn-primary btn-lg btn-block" type="submit">Buscar Cliente</button>
                    </form>
                    <?php if ($consultaFalhou) { ?>
                        <h5 class="mb-3 font-weight-normal text-danger">Não encontrado cliente com CPF informado!</h5>
                    <?php } ?>
                </div>
            </div>

        </div>

        <div class="row justify-content-md-center">

            <div class="col-md-8">

                <form method="post">

                    <hr class="mb-4">
                    <input type="hidden" name="tipo_op" value="<?= $tipo_op ?>">

                    <?php
                    if (isset($_SESSION['msg_alteracao'])) {
                        echo ($_SESSION['msg_alteracao']);
                        unset($_SESSION['msg_alteracao']);
                    } ?>

                    <h4 class="mb-3">Dados do Cliente</h4>

                    <div class="mb-3">
                        <label for="nome">CPF</label>
                        <input type="text" class="form-control" name="cpf" value="<?= $cpf ?>" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" name="nome" value="<?= $nomeCli ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" class="form-control" name="sobrenome" value="<?= $sobrenome ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $email ?>">
                    </div>

                    <div class="mb-3">
                        <label for="endereco">Endereço</label>
                        <input type="text" class="form-control" name="endereco" value="<?= $endereco ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-5 mb-3">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" name="cidade" placeholder="" value="<?= $cidade ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" name="estado" placeholder="" value="<?= $estado ?>">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control" name="cep" placeholder="" value="<?= $cep ?>">
                        </div>
                    </div>

                    <hr class="mb-4">

                    <button class="btn btn-<?= ($tipo_op == 'c') ? 'success' : 'primary' ?> btn-lg btn-block" type="submit"><?= ($tipo_op == 'c') ? 'Cadastrar' : 'Editar' ?> Cliente</button>

                </form>
            </div>


        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2021</p>
        </footer>
    </div>

</body>

</html>