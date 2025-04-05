<?php
$dados = $_POST;

if($dados['id']){
    $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

    $sql = "UPDATE pessoas SET nome     = '{$dados['nome']}',
                               endereco = '{$dados['endereco']}',
                               bairro   = '{$dados['bairro']}',
                               telefone = '{$dados['telefone']}',
                               email    = '{$dados['email']}',
                              id_cidade = '{$dados['id_cidade']}'
                           WHERE id = '{$dados['id']}'
    ";
    $result= $conn->query($sql);
    
    if($result)
    {
        print 'Registro atualizado com sucesso';
    }else
    {
        print mysqli_error($conn);
    }
    $conn->close();
}