<?php

class Pessoa
{
    private static function connect()
    {
        $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }
        return $conn;
    }

    public static function find($id)
    {
        $conn = self::connect();
        $stmt = $conn->prepare("SELECT * FROM pessoas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pessoa = $result->fetch_assoc();
        $stmt->close();
        $conn->close();
        return $pessoa;
    }

    public static function delete($id)
    {
        $conn = self::connect();
        $stmt = $conn->prepare("DELETE FROM pessoas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        $conn->close();
        return $success;  
    }

    public static function all()
    {
        $conn = self::connect();
        $stmt = $conn->prepare("SELECT * FROM pessoas ORDER BY id");
        $stmt->execute();
        $result = $stmt->get_result();
        $list = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conn->close();
        return $list;
    }

    public static function save($pessoa)
    {
        $conn = self::connect();
        if(empty($pessoa['id'])){
            $result = $conn->query("SELECT max(id) as next FROM pessoas");

            $row = $result->fetch_assoc();

            $pessoa['id'] = $row['next'] + 1;

            $sql = "INSERT INTO pessoas(id, nome, endereco, bairro, telefone, email,id_cidade)
            VALUES ('{$pessoa['id']}',  '{$pessoa['nome']}', 
                                '{$pessoa['endereco']}', 
                                '{$pessoa['bairro']}', 
                                '{$pessoa['telefone']}',
                                '{$pessoa['email']}', 
                                '{$pessoa['id_cidade']}')";

        }else
        {
            $sql = "UPDATE pessoas SET nome     = '{$pessoa['nome']}',
            endereco = '{$pessoa['endereco']}',
            bairro   = '{$pessoa['bairro']}',
            telefone = '{$pessoa['telefone']}',
            email    = '{$pessoa['email']}',
           id_cidade = '{$pessoa['id_cidade']}'
        WHERE id = '{$pessoa['id']}'
        ";
        
        }
        $result = $conn->query($sql);
        $conn->close();

        return $result;
    }
}