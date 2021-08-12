<?php

function lista_combo_cidades( $id_cidade )
{
    $conn = pg_connect('host=localhost port=5433 dbname=livros user=postgres password=123456 sslmode=allow');
    $output = '';
    $result = pg_query($conn, 'SELECT id, nome From cidade');

    if ($result) {
        while ($row = pg_fetch_assoc($result)) {
            $id = $row['id'];
            $nome = $row['nome'];
            $check = ($id == $id_cidade) ? 'selected=1' : '';
            $output .= "<option {$check} value='{$id}'> $nome </option>";
        }
    }

    pg_close($conn);

    return $output;
}
