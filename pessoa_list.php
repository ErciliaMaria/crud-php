<?php
$conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

if( !empty($_GET['action']) and ($_GET['action'] == 'delete'))
{
    $id = (int) $_GET['id'];

    $conn->query("DELETE FROM pessoas WHERE id='{$id}'");
}
            
$result = $conn->query('SELECT * FROM pessoas ORDER BY id');

$items = '';
while ($row = $result->fetch_assoc())
{
    $item = file_get_contents('html/item.html');
    $item = str_replace('{id}', $row['id'], $item);
    $item = str_replace('{nome}', $row['nome'], $item);
    $item = str_replace('{endereco}', $row['endereco'], $item);
    $item = str_replace('{bairro}', $row['bairro'], $item);
    $item = str_replace('{telefone}', $row['telefone'], $item);
    $item = str_replace('{email}', $row['email'], $item);

    $items .= $item;
}

$list = file_get_contents('html/list.html');
$list = str_replace('{items}', $items, $list);

print $list;
?>
