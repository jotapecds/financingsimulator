<?php

$NP = $_GET['np'];
$TAX = $_GET['tax'];
$PV = $_GET['pv'];
$PP = $_GET['pp'];
$PB = $_GET['pb'];
$existe_entrada = $_GET['np'] != null;

$price_table_data = [];

if(isset($NP) && isset($TAX) && isset($PV) && isset($PP) && isset($PB) && isset($existe_entrada)) {
    $price_table_data = calculatePriceTable($NP, $PV, $PP, $TAX, $existe_entrada);
}

function calculatePriceTable($np, $pv, $pp, $t, $e) {

    $coefFinanc = calculateFinancingCoefficient($t,$np);
    
    if($pp == 0.0) {
        $pp = round($pv/calculateAppliedFactor($np, $t, $coefFinanc, $e), 2);
    }

    $jurosReal = calculateInterestRate($np,$pv,$pp,$e) * 100;
    $pmt = round($pv*$coefFinanc, 2);
    $jurosUsado = ($t > 0) ? $t : round($jurosReal, 4);
    $juros = $jurosUsado;
    $jurosTotal = 0;
    $totalPago = 0;
    $amortizacaoTotal = 0;
    $amortizacao = 0;
    $saldoDevedor = $pv;
    $matrizPrice = [];

    // Se existir entrada, dimunui o número de parcelas restantes
    if($e) $np--;

    for($i = 1; $i <= $np; $i++){
        $juros = round($saldoDevedor*$jurosUsado/100, 2);
        $amortizacao = round($pmt-$juros, 2);
        $saldoDevedor -=  $amortizacao;
        $saldoDevedor = $saldoDevedor > 0 ? round($saldoDevedor, 2) : 0;
     
        array_push($matrizPrice, [$i, $pmt, $juros, $amortizacao, $saldoDevedor]);

        $jurosTotal += Number($juros);
        $totalPago += Number($pmt);
        $amortizacaoTotal += Number($amortizacao);
    }

    array_push($matrizPrice, ["Total: {round($totalPago, 2)}, {round($jurosTotal, 2)}, {round($amortizacaoTotal,2)}, {round($saldoDevedor, 2)}"]);

    return $matrizPrice;
}