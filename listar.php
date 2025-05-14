<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "estoque";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM produtos ORDER BY data_validade ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Produtos Cadastrados</h2>
    
    <!-- Filtro de exibição -->
    <div class="filtro">
        <label for="filter">Filtrar produtos:</label>
        <select id="filter">
            <option value="todos">Mostrar todos</option>
            <option value="desconto">Ocultar todos com desconto</option>
            <option value="50">Ocultar produtos com 50% de desconto</option>
            <option value="20">Ocultar produtos com 20% de desconto</option>
            <option value="0">Ocultar produtos sem desconto</option>
        </select>
    </div>
    
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Preço Original</th>
            <th>Preço Final</th>
            <th>Data de Fabricação</th>
            <th>Data de Validade</th>
            <th>Ações</th>
        </tr>

        <?php
        while ($row = $result->fetch_assoc()) {
            $preco_original = $row["preco"];
            $preco_final = $preco_original;
            $hoje = date("Y-m-d");
            $dias_para_validade = (strtotime($row["data_validade"]) - strtotime($hoje)) / (60 * 60 * 24);

            $desconto = 0;
            if ($dias_para_validade < 7) {
                $preco_final *= 0.5;
                $desconto = 50;
            } elseif ($dias_para_validade < 30) {
                $preco_final *= 0.8;
                $desconto = 20;
            }

            // Define a classe da linha conforme o desconto
            $classe = ($desconto == 50) ? "desconto50" : (($desconto == 20) ? "desconto20" : "sem-desconto");

            echo "<tr class='{$classe}' data-desconto='{$desconto}'>
                    <td>{$row['id']}</td>
                    <td>{$row['nome']}</td>
                    <td>{$row['quantidade']}</td>
                    <td>R$ " . number_format($preco_original, 2, ',', '.') . "</td>
                    <td>R$ " . number_format($preco_final, 2, ',', '.') . "</td>
                    <td>{$row['data_fabricacao']}</td>
                    <td>{$row['data_validade']}</td>
                    <td class='acao'>
                        <a href='editar.php?id={$row["id"]}'>Editar</a>
                        <a href='remover_quantidade.php?id={$row["id"]}'>Remover Quantidade</a>
                    </td>
                  </tr>";
        }
        ?>
    </table>
    <br>
    <a href="index.php">Cadastrar novo produto</a>

    <!-- JavaScript para o filtro -->
    <script>
        document.getElementById("filter").addEventListener("change", function(){
            var filtro = this.value;
            var linhas = document.querySelectorAll("table tr[data-desconto]");
            linhas.forEach(function(linha){
                var desconto = linha.getAttribute("data-desconto");
                // Se "todos" for selecionado, mostra todas as linhas
                if(filtro === "todos") {
                    linha.style.display = "";
                } else if(filtro === "desconto") {
                    // Oculta linhas que tenham qualquer desconto (50 ou 20)
                    linha.style.display = (desconto > 0) ? "none" : "";
                } else {
                    // filtro específico: 50, 20 ou 0 (sem desconto)
                    linha.style.display = (desconto === filtro) ? "none" : "";
                }
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?>
