<html>
<head>
    <meta charset="utf-8">
    <title> Listagem de pessoas</title>
    <link href="css/list.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
<table border=1>
    <thead>
    <tr>
        <td>editar</td>
        <td>excluir</td>
        <td></td>
        <td>ID</td>
        <td>Nome</td>
        <td>Endereço</td>
        <td>Bairro</td>
        <td>Telefone</td>
        <td>Email</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $conn = pg_connect('host=localhost port=5433 dbname=livros user=postgres password=123456 sslmode=allow');

    if (!empty($_GET['action']) and ($_GET['action'] == 'delete')) {
        $id = (int)$_GET['id'];
        pg_query($conn, "DELETE FROM pessoa WHERE id='{$id}'");
    }

    $result = pg_query($conn, 'SELECT * from pessoa ORDER BY id');

    while ($row = pg_fetch_assoc($result)) {
        $id        = $row['id'];
        $nome      = $row['nome'];
        $endereco  = $row['endereco'];
        $bairro    = $row['bairro'];
        $telefone  = $row['telefone'];
        $email     = $row['email'];

        print '<tr>';
        print "<td> <a href='pessoa_form.php? action==edit&id={$id}'><img src='editar.png' style='width:20px'> 
                               </a>
                              </td>";
        print "<td> <a href='pessoa_list.php? action=delete& id={$id}'><img src='excluir.png' style='width:15px'> 
                               </a>
                              </td>";
        print "<td> </td>";
        print "<td> {$id} </td>";
        print "<td> {$nome} </td>";
        print "<td> {$endereco} </td>";
        print "<td> {$bairro} </td>";
        print "<td> {$telefone} </td>";
        print "<td> {$email} </td>";
        print '<tr>';
    }
    ?>
    </tbody>
</table>
<button onclick="window.location='pessoa_form.php'">
    <img src="" style="width:17px"> Inserir
</button>
</body>
</html>
