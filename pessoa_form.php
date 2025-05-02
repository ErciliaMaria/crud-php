<?php
    $pessoa = [];
    $pessoa['id']        = '';
    $pessoa['nome']      = '';
    $pessoa['endereco']  = '';
    $pessoa['bairro']    = '';
    $pessoa['telefone']  = '';
    $pessoa['email']     = '';
    $pessoa['id_cidade'] = '';

    if (!empty($_REQUEST['action'])) {
        $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

        if ($_REQUEST['action'] === 'edit') {
            if (!empty($_GET['id'])) {
                $id = (int) $_GET['id'];
                $result = $conn->query("SELECT * FROM pessoas WHERE id='{$id}'");

                $pessoa = $result->fetch_assoc();
            }
        } else if ($_REQUEST['action'] === 'save') {
            $id = $_POST['id'];
            $pessoa = $_POST;

            if (empty($_POST['id'])) {
                $dados = $_POST;

                $result = $conn->query('SELECT MAX(id) as next FROM pessoas');

                $row = $result->fetch_assoc();
                $next = (int) $row['next'] + 1;

                $sql = "INSERT INTO pessoas(id, nome, endereco, bairro, telefone, email,id_cidade)
                VALUES ('{$next}',  '{$pessoa['nome']}', 
                                    '{$pessoa['endereco']}', 
                                    '{$pessoa['bairro']}', 
                                    '{$pessoa['telefone']}',
                                    '{$pessoa['email']}', 
                                    '{$pessoa['id_cidade']}')";
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

                $sql = "UPDATE pessoas SET nome     = '{$pessoa['nome']}',
                               endereco = '{$pessoa['endereco']}',
                               bairro   = '{$pessoa['bairro']}',
                               telefone = '{$pessoa['telefone']}',
                               email    = '{$pessoa['email']}',
                              id_cidade = '{$pessoa['id_cidade']}'
                           WHERE id = '{$pessoa['id']}'
                        ";
                $result = $conn->query($sql);

                print ($result) ? 'Registro atualizado com sucesso' : print mysqli_error($conn);
            
                $conn->close();
            }
        }
    }
    require_once 'lista_combo_cidades.php';
    $cidades = lista_combo_cidades($pessoa['id_cidade']);

    $form = file_get_contents('html/form.html');
    $form = str_replace('{id}', $pessoa['id'], $form);
    $form = str_replace('{nome}', $pessoa['nome'], $form);
    $form = str_replace('{endereco}', $pessoa['endereco'], $form);
    $form = str_replace('{bairro}', $pessoa['bairro'], $form);
    $form = str_replace('{telefone}', $pessoa['telefone'], $form);
    $form = str_replace('{email}', $pessoa['email'], $form);
    $form = str_replace('{id_cidade}', $pessoa['id_cidade'], $form);
    $form = str_replace('{cidades}', $cidades, $form);
    
    print $form;
?>