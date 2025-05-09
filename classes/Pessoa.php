<?php

class Pessoa
{
    private static $conn;

    private static function connect()
    {
        if(empty(self::$conn)){
            $ini = parse_ini_file('config/livro.ini');
            $host = $ini['host'];
            $name = $ini['name'];
            $user = $ini['user'];
            $pass = $ini['password'];
            self::$conn = new mysqli($host, $user, $pass, $name, 3306);        if (self::$conn->connect_error) {
            die("Erro de conexão: " . self::$conn->connect_error);
        }
        }
        return self::$conn;
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
        return $pessoa;
    }

    public static function delete($id)
    {
        $conn = self::connect();
        $stmt = $conn->prepare("DELETE FROM pessoas WHERE id = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;  
    }

    public static function all()
    {
        $conn = self::connect();
        $stmt = $conn->prepare("SELECT * FROM pessoas ORDER BY id");
        $stmt->execute();
        $result = $stmt->get_result();
        $pessoas = [];
        while ($row = $result->fetch_assoc()) {
            $pessoas[] = $row;
        }
    
        $stmt->close();
        return $pessoas;
    }

    public static function save($pessoa)
    {
        $conn = self::connect();
        if(empty($pessoa['id'])){
            $result = $conn->query("SELECT max(id) as next FROM pessoas");
            
            $row = $result->fetch_assoc();
            $pessoa['id'] = $row['next'] + 1;

            $sql = "INSERT INTO pessoas (nome, endereco, bairro, telefone, email, id_cidade)
                VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssssi",
                $pessoa['nome'],
                $pessoa['endereco'],
                $pessoa['bairro'],
                $pessoa['telefone'],
                $pessoa['email'],
                $pessoa['id_cidade']
            );
            $success = $stmt->execute();
            $stmt->close();
            return $success;

        }else
        {
            $sql = "UPDATE pessoas SET nome     = ?,
            endereco = ?,
            bairro   = ?,
            telefone = ?,
            email    = ?,
           id_cidade = ?
        WHERE id = ?
        ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "ssssssi", 
                $pessoa['nome'],
                $pessoa['endereco'],
                $pessoa['bairro'],
                $pessoa['telefone'],
                $pessoa['email'],
                $pessoa['id_cidade'],
                $pessoa['id'] 
            );
            $success = $stmt->execute();
            $stmt->close();
            return $success;
        }
    }
}