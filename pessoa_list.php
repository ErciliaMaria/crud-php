<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de pessoas</title>
    <link href="css/list.css" rel="stylesheet" type="text/css" media="screen">
</head>
<body>
    <table border=1>
        <thead>
            <tr>
                <td></td>
                <td></td>
                <td>Id</td>
                <td>Nome</td>
                <td>Endereço</td>
                <td>Bairro</td>
                <td>Telefone</td>
                <td>Email</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

            if( !empty($_GET['action']) and ($_GET['action'] == 'delete'))
            {
                $id = (int) $_GET['id'];

                $conn->query("DELETE FROM pessoas WHERE id='{$id}'");
            }
            
            $result = $conn->query('SELECT * FROM pessoas ORDER BY id');

            while ($row = $result->fetch_assoc())
            {
                $id = $row['id'];
                $nome = $row['nome'];
                $endereco = $row['endereco'];
                $bairro = $row['bairro'];
                $telefone = $row['telefone'];
                $email = $row['email'];
                $id_cidade = $row['id_cidade'];

                print '<tr>';
                print "<td><a href='pessoa_form.php?action=edit&id={$id}'>
                <img src='./img/edit.jpg'>
                </a></td>";
                print "<td><a href='pessoa_list.php?action=delete&id={$id}'>
                <img src='./img/remove.jpg'>
                </a></td>";
                print "<td>{$id}</td>";
                print "<td>{$nome}</td>";
                print "<td>{$endereco}</td>";
                print "<td>{$bairro}</td>";
                print "<td>{$telefone}</td>";
                print "<td>{$email}</td>";
                print '</tr>';
            }
            ?>
        </tbody>
    </table>

    <button onclick="window.location='pessoa_form.php'">
        <img src="./img/insert.jpg" alt="inserção">
    </button>

</body>
</html>