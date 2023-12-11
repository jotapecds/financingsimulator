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
        <?php

            $cf = calculateFinancingCoefficient($TAX, $NP);
            $cf_rouded = round($cf);
            $prest = roud($PV*$cf);
            $tx_real = calculateInterestRate($NP,$PV,$PP,$existe_entrada) * 100;

            echo "<li>Parcelas: {$NP}</li>
                    <li>Taxa de juros: {$TAX}%</li>
                    <li>Valor Financiado: {$PV}</li>
                    <li>Valor a voltar: {$PP}</li>
                    <li>Meses a voltar: {$PB}</li>
                    <li>Entrada(?): {$existe_entrada}</li>
                    <br>
                    <li>Coeficiente de Financiamento: {$cf_rouded}</li>
                    <li>Prestação: {$prest}</li>
                    <li>Valor pago: </li>
                    <li>Taxa real: {$tx_real}</li>
                    <li>Valor corrigido: </li>";
        ?>
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
            
            <!-- Construída dinamicamente -->

            <?php
                foreach ($price_table_data as $row) {
                    echo '<tr>';
                    foreach ($row as $data) {
                        echo "<td>$data</td>";
                    }
                    echo '</tr>';
            }
            ?>
            
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