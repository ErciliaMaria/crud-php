<?php
function lista_combo_cidades($id_cidade = null) {
    $conn = new mysqli('localhost', 'root', '', 'cadastro_pessoa', 3306);

    if ($conn->connect_error) {
        die("Falha na conexão: " . $conn->connect_error);
    }

    $output = '';
    $result = $conn->query('SELECT id, nome FROM cidades');

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $nome = $row['nome'];

            $check = ($id == $id_cidade) ? 'selected=1' : '';
            
            $output .= "<option {$check} value='{$id}'> $nome</option>";
        }
    }

    $conn->close();
    return $output;
}
?>
