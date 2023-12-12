<?php

$NP = $_GET['np'];
$TAX = $_GET['tax'];
$PV = $_GET['pv'];
$PP = $_GET['pp'];
$PB = $_GET['pb'];
$existe_entrada = isset($_GET['dp']);

$price_table_data = [];

if(isset($NP) && isset($TAX) && isset($PV) && isset($PP) && isset($PB)) {
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

        $jurosTotal += $juros;
        $totalPago += $pmt;
        $amortizacaoTotal += $amortizacao;
    }

    array_push($matrizPrice, ["Total:", round($totalPago, 2), round($jurosTotal, 2), round($amortizacaoTotal,2), round($saldoDevedor, 2)]);

    return $matrizPrice;
}

function calculateFinancingCoefficient($t, $np) {
    $taxa_corrigida = $t/100;
    return $taxa_corrigida/(1-pow(1+$taxa_corrigida, -$np));
}

function calculateAppliedFactor($np, $t, $coef_financ, $e){
    return fe($e, $t)/($np*$coef_financ);
}

function fe($e, $t){
    return $e ? 1+$t : 1;
}

function calculateInterestRate($np,$pv,$pp,$e) {
    $tolerancia = 0.0001;  
    $t = 0.1; // Palpite inicial
    $t0 = 0.0;

    $funcao = 0; 
    $derivada = 0;
    $i = 0;
    
    while(abs($t0-$t) >= $tolerancia){
        $t0 = $t;
        $funcao = calcularValorFuncao($np, $pv, $pp, $t, $e);
        $derivada = calcularValorDerivadaFuncao($np, $pv, $pp, $t, $e);
        $t = $t - ($funcao / $derivada);
        $i++;
    }
    return $t;
}

function calcularValorFuncao($np, $pv, $pp, $t, $e){
    $a = 0; 
    $b = 0; 
    $c = 0;

    if($e) {
        $a = pow(1 + $t, $np - 2);
        $b = pow(1 + $t, $np - 1);
        $c = pow(1 + $t, $np);

        return ($pv*$t*$b) - ($pp/$np*($c - 1));
    }
    else {
        $a = pow(1 + $t, -$np);
        $b = pow(1 + $t, -$np - 1);

        return ($pv*$t) - (($pp/$np)*(1 - $a)); 
    }
}
    
function calcularValorDerivadaFuncao($np, $pv, $pp, $t, $e){
    $a = 0; 
    $b = 0;

    if($e) {
        $a = pow(1 + $t, $np - 2);
        $b = pow(1 + $t, $np - 1);

        return $pv * ($b + ($t*$a*($np-1))) - ($pp*$b);
    }
    else {
        $a = pow(1 + $t, -$np);
        $b = pow(1 + $t, -$np - 1);

        return $pv - ($pp*$b);
    }
}
