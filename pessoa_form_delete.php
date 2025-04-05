<?php

$dados = $_GET;

$conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

$id = (int) $dados['id'];

$sql = "DELETE FROM pessoas WHERE id ='{$id}'";
$result = $conn->query($sql);
if($result){
    print 'Registro excluído com sucesso';
}else{
    print mysqli_error($conn);
}