<html>
<head>
    <meta charset="UTF-8">
    <title> Cadastro de pessoa</title>
    <link href="css/form.css" rel="stylesheet" type="text/css" media="screen"/>
</head>
<body>
<?php

$id = '';
$nome = '';
$endereco = '';
$bairro = '';
$telefone = '';
$email = '';
$id_cidade = '';

if (!empty($_REQUEST['action'])) {
    $conn = pg_connect('host=localhost port=5433 dbname=livros user=postgres password=123456 sslmode=allow');

    if (!empty($_GET['id'])) {
        $id = (int)$_GET['id'];
        $result = pg_query($conn, "SELECT * FROM pessoa WHERE id='{$id}'");
        $row = pg_fetch_assoc($result);

        $id = $row['id'];
        $nome = $row['nome'];
        $endereco = $row['endereco'];
        $bairro = $row['bairro'];
        $telefone = $row['telefone'];
        $email = $row['email'];
        $id_cidade = $row['id_cidade'];
    }

    if ($_REQUEST['action'] == 'save') {
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $endereco = $_POST['endereco'];
        $bairro = $_POST['bairro'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];
        $id_cidade = $_POST['id_cidade'];

        if (empty($_POST['id'])) {
            $result = pg_query($conn, "SELECT max(id) as next FROM pessoa");
            $row = pg_fetch_assoc($result);
            $next = (int)$row['next'] + 1;

            $sql = "INSERT INTO pessoa (
                        id,
                        nome,
                        endereco,
                        bairro,
                        telefone,
                        email,
                        id_cidade
                    ) VALUES (
                        '{$next}',
                        '{$nome}',
                        '{$endereco}',
                        '{$bairro}',
                        '{$telefone}',
                        '{$email}',
                        '{$id_cidade}'
                    )";

           $result = pg_query($conn, $sql);
        }
        else
        {
            $sql = "UPDATE pessoa SET nome = '{$nome}',
                                      endereco = '{$endereco}',
                                      bairro = '{$bairro}',
                                      telefone = '{$telefone}',
                                      email = '{$email}',
                                      id_cidade = '{$id_cidade}'
                                      WHERE id = '{$id}'";
            $result = pg_query($conn, $sql);
        }

        print ($result) ? 'Registro salvo com sucesso' : pg_last_error($conn);
        pg_close($conn);
    }
}
?>
<form enctype="multipart/form-data" method="post" action="pessoa_form.php?action=save">
    <label>Código </label>
    <input name="id" readonly="1" type="text" value="<?= $id ?>" style="width:30%">

    <label>Nome </label>
    <input name="nome" type="text" value="<?= $nome ?>" style="width:50%">

    <label>Endereço </label>
    <input name="endereco" type="text" value="<?= $endereco ?>" style="width:50%">

    <label> Bairro </label>
    <input name="bairro" type="text" value="<?= $bairro ?>" style="width:25%">

    <label> Telefone </label>
    <input name="telefone" type="text" value="<?= $telefone ?>" style="width:25%">

    <label> Email </label>
    <input name="email" type="text" value="<?= $email ?>" style="width:25%">

    <label> Cidade </label>
    <select name="id_cidade" value="<?= $id_cidade ?>" style="width: 25%">
        <?php
        require_once 'lista_combo_cidades.php';
        print lista_combo_cidades($id_cidade);
        ?>
    </select>
    <input type="submit">
</form>
</body>
</html>
