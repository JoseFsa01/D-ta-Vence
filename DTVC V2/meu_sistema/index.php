<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Cadastro de Produto</h2>
    <form action="salvar.php" method="POST">
        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>Quantidade:</label>
        <input type="number" name="quantidade" required>

        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" required>

        <label>Data de Fabricação:</label>
        <input type="date" name="data_fabricacao" required>

        <label>Data de Validade:</label>
        <input type="date" name="data_validade" required>

        <button type="submit">Salvar</button>
    </form>
    <br>
    <a href="listar.php">Ver produtos cadastrados</a>
</body>
</html>
