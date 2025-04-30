<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link href="css/form.css" rel="stylesheet" type="text/css" media="screen">
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
        $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

        if ($_REQUEST['action'] === 'edit') {
            if (!empty($_GET['id'])) {
                $id = (int) $_GET['id'];
                $result = $conn->query("SELECT * FROM pessoas WHERE id='{$id}'");

                $row = $result->fetch_assoc();

                $id = $row['id'];
                $nome = $row['nome'];
                $endereco = $row['endereco'];
                $bairro = $row['bairro'];
                $telefone = $row['telefone'];
                $email = $row['email'];
                $id_cidade = $row['id_cidade'];
            }
        } else if ($_REQUEST['action'] === 'save') {
            $id = $_POST['id'];
            $nome = $_POST['nome'];
            $endereco = $_POST['endereco'];
            $bairro = $_POST['bairro'];
            $telefone = $_POST['telefone'];
            $email = $_POST['email'];
            $id_cidade = $_POST['id_cidade'];

            if (empty($_POST['id'])) {
                $dados = $_POST;

                $result = $conn->query('SELECT MAX(id) as next FROM pessoas');

                $row = $result->fetch_assoc();
                $next = (int) $row['next'] + 1;

                $sql = "INSERT INTO pessoas(id, nome, endereco, bairro, telefone, email,id_cidade)
VALUES ('{$next}',  '{$dados['nome']}', '{$dados['endereco']}', '{$dados['bairro']}', '{$dados['telefone']}', '{$dados['email']}', '{$dados['id_cidade']}')";

                $result = mysqli_query($conn, $sql);

                if ($result) {
                    print "Registro inserido com sucesso!";
                } else {
                    print "Erro ao inserir: " . mysqli_error($conn);
                }
                $conn->close();
            } else {
                $dados = $_POST;

                $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

                $sql = "UPDATE pessoas SET nome     = '{$dados['nome']}',
                               endereco = '{$dados['endereco']}',
                               bairro   = '{$dados['bairro']}',
                               telefone = '{$dados['telefone']}',
                               email    = '{$dados['email']}',
                              id_cidade = '{$dados['id_cidade']}'
                           WHERE id = '{$dados['id']}'
                        ";
                $result = $conn->query($sql);

                print ($result) ? 'Registro atualizado com sucesso' : print mysqli_error($conn);
            
                $conn->close();
            }
        }
    }
    ?>
    <form enctype="multipart/form-data" method="post" action="pessoa_form.php?action=save">
        <label for="">Código</label>
        <input name="id" readonly="1" type="text" value="<?= $id ?>">

        <label for="">Nome</label>
        <input name="nome" type="text" value="<?= $nome ?>">

        <label for="">Endereço</label>
        <input name="endereco" type="text" value="<?= $endereco ?>">

        <label for="">Bairro</label>
        <input name="bairro" type="text" value="<?= $bairro ?>">

        <label for="">Telefone</label>
        <input name="telefone" type="text" value="<?= $telefone ?>">

        <label for="">Email</label>
        <input name="email" type="text" value="<?= $email ?>">

        <label for="">Cidade</label>
        <select name="id_cidade">
            <?php
            require_once 'lista_combo_cidades.php';
            print lista_combo_cidades($id_cidade);
            ?>
        </select>

        <input type="submit">
    </form>
</body>

</html>