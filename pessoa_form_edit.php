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
        if(!empty($_GET['id']))
        {
            $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

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
        ?>
        <form enctype="multipart/form-data" method="post" action="pessoa_save_update.php">
            <label for="">Código</label>
            <input name="id" readonly="1" type="text" value="<?=$id?>">

            <label for="">Nome</label>
            <input name="nome" type="text" value="<?=$nome?>">

            <label for="">Endereço</label>
            <input name="endereco" type="text" value="<?=$endereco?>">

            <label for="">Bairro</label>
            <input name="bairro" type="text" value="<?=$bairro?>">

            <label for="">Telefone</label>
            <input name="telefone" type="text" value="<?=$telefone?>">

            <label for="">Email</label>
            <input name="email" type="text" value="<?=$email?>">

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