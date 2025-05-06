<?php

function get_pessoa($id)
{
    $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM pessoas WHERE id = '{$id}'");

    $pessoa = $result->fetch_assoc();
    $conn->close();

    return $pessoa;
}

function excluir_pessoa($id)
{
    $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $pessoa = $conn->query("DELETE FROM pessoas WHERE id = '{$id}'");
    $conn->close();

    return $pessoa;
}

function insert_pessoa($pessoa)
{
    $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

    $sql = "INSERT INTO pessoas(id, nome, endereco, bairro, telefone, email,id_cidade)
                VALUES ('{$pessoa['id']}',  '{$pessoa['nome']}', 
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

    return $result;
}

function update_pessoa($pessoa)
{
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

    $conn->close();

    return $result;
}
function lista_pessoas() {
    $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT * FROM pessoas ORDER BY id");

    $list = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();

    return $list;
}
function get_next_pessoa() {
    $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

    if ($conn->connect_error) {
        die("Erro de conexão: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT max(id) as next FROM pessoas");

    $pessoa = $result->fetch_assoc();
    $next = $pessoa['next'] + 1;
    $conn->close();

    return $next;
}
