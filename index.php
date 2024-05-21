<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atividade Biblioteca</title>
</head>
<body>
    <?php 
        require "Biblioteca.php";

        //Foi pedido que seja passado uma lista(array) com os livros emprestados e disponiveis, é necessário o var_dump.
        echo "<strong>LIVROS EMPRESTADOS -> </strong>";
        echo  var_dump($biblioteca->listarLivrosEmprestado()) . "<br><br>";
        echo "<strong>LIVROS DISPONÍVEIS -> </strong>";
        echo  var_dump($biblioteca->listarLivrosDisponiveis()) . "<br><br>";
    ?>
</body>
</html>
