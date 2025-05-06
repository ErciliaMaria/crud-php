<?php

class Cidade{

    private static function connect()
    {
        $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);
        if ($conn->connect_error) {
            die("Erro de conexão: " . $conn->connect_error);
        }
        return $conn;
    }

    public static function all()
    {
        $conn = self::connect();
        $stmt = $conn->prepare("SELECT * FROM cidades ORDER BY id");
        $stmt->execute();
        $result = $stmt->get_result();
        $list = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $conn->close();
        return $list;
    }
}