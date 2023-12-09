<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Table</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include 'price.php'; ?>

    <button
        class="simulate-button" 
        onclick="window.location.href = '../index.html'">
        Simular novamente
    </button>
    
    <div id="details-container">
        <h3 id="details-header"><span>&#8688;</span>Informações detalhadas</h3>
        <ul id="details-list" style="display: none;">
            <li id="li-parc">Parcelas: </li>
            <li id="li-taxa">Taxa de juros: </li>
            <li id="li-vf">Valor Financiado: </li>
            <li id="li-vv">Valor a voltar: </li>
            <li id="li-mv">Meses a voltar: </li>
            <li id="li-entrada">Entrada(?) : </li>
            <br>
            <li id="li-cf">Coeficiente de Financiamento: </li>
            <li id="li-prest">Prestação: </li>
            <li id="li-vp">Valor pago: </li>
            <li id="li-tr">Taxa real: </li>
            <li id="li-vc">Valor corrigido: </li>
        </ul>
    </div>

    <div id="table-containter" class="containter">
        <h3>Tabela Price</h3>
        <table id="price-table">
            <tr>
                <th>Mês</th>
                <th>Prestação</th>
                <th>Juros</th>
                <th>Amortização</th>
                <th>Saldo Devedor</th>
            </tr>
            <tr>
            <?php
            foreach ($lista as $item) {
                echo "<td>$item</td>";
            }
            ?>
            </tr>
            
            <!-- Construída dinamicamente -->
        </table>
    </div>
    
    <br><br>
    <button
        class="simulate-button" 
        onclick="window.location.href = '../index.html'">
        Simular novamente
    </button>

    <script src="../price.js"></script>
</body>
</html>