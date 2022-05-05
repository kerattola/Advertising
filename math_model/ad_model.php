<?php
//обчислює функцію
function N($t, $alpha1, $alpha2, $k, $N0)
{
    $Nt1 = -($alpha1 / $alpha2);
    $Nt21 = ($alpha1 / $alpha2) + $N0;
    $ex = exp(-$k * (($alpha1 / $alpha2) + $N0) * ($alpha2 * $t));
    $Nt2 = 1 + ($alpha2 / $alpha1) * $N0 * $ex;
    $Nt = $Nt1 + ($Nt21 / $Nt2);
    return $Nt;
}

function N_before_T1($t, $alpha_max, $alpha21, $k, $N0)
{
    $Nt1 = ($alpha_max / $alpha21);
    $Nt21 = $alpha_max + ($alpha21 * $N0);
    $ex = exp(-$k * (($alpha_max / $alpha21) + $N0) * ($alpha21 * $t));
    $Nt2 = $alpha_max + ($alpha21 * $N0 * $ex);
    $Nt = $Nt1 * (($Nt21 / $Nt2) - 1);
    return $Nt;
}

function N_after_T1($t, $T1, $alpha_opt, $alpha22, $k, $N0, $N1)
{
    $Nt1 = -($alpha_opt / $alpha22);
    $Nt21 = ($alpha_opt / $alpha22) + $N0;
    $ex = exp(-$k * (($alpha_opt / $alpha22) + $N0) * $alpha22 * ($t - $T1));
    $Nt2 = 1 + ((($N0 - $N1) / ($N1 + ($alpha_opt / $alpha22))) * $ex);
    $Nt = $Nt1 + ($Nt21 / $Nt2);
    return $Nt;
}

function main1($alpha1, $alpha2, $k, $N0)
{
    $N_t = array();
    $T = array();

for ($t = 0; $t < 101; $t++) {
    $t1 = $t * 0.01;
    $Nt = N($t1, $alpha1, $alpha2, $k, $N0);
    $N_t[$t] = $Nt;
    $T[$t] = $t1;
}
    return array($T, $N_t);
}

function change_point($alpha2, $alpha1, $k, $N0)
{
    $T1 = log(($alpha2 / $alpha1) * $N0) / ($k * (($alpha1 / $alpha2) + $N0) * $alpha2);
    $N1 = N($T1, $alpha1, $alpha2, $k, $N0);

    return array($T1, $N1);
}

function isreason($p, $alpha2, $alpha1, $k, $N0, $s)
{
    $a = ($p * $alpha2) * ((pow($alpha1,2)/pow($alpha2,2)) +
        2 * $N0 * (1 - 2 * $k) * ($alpha1/$alpha2) + pow($N0,2));
    $b = $s * ($alpha1/$alpha2);

    if ($a > $b){
        return true;
    } else{
        return false;
    }
}

function main2($alpha2, $alpha1, $alpha_opt, $alpha22, $k, $N0){
    $N_alpha = array();
    $T_alpha = array();

    list($T1, $N1) = change_point($alpha2, $alpha1, $k, $N0);

    $t = 0;
    while ($t <= ($T1 * 100)){
        $t1 = $t * 0.01;
        $Nt = N_before_T1($t1, $alpha1, $alpha2, $k, $N0);
        $N_alpha[$t] = $Nt;
        $T_alpha[$t] = $t1;
        $t += 1;

    }
    while ($t <= 100){
        $t1 = $t * 0.01;
        $Nt = N_after_T1($t1, $T1, $alpha_opt, $alpha22, $k, $N0, $N1);
        $N_alpha[$t] = $Nt;
        $t += 1;
    }
    return array($T_alpha, $N_alpha);
}

function sum_spend_first($s, $alpha1){
    return $s * $alpha1 * 100;
}

function sum_spend_second($s, $alpha1, $T1, $alpha_opt){
    return ($s * $alpha1 * $T1 * 100) + ($s * $alpha_opt * (100 - ($T1 * 100)));
}

function income_first($p, $alpha1, $alpha2, $k, $N0){
    $Nt = N(1, $alpha1, $alpha2, $k, $N0);
    return $p * $Nt;
}

function income_second($p, $alpha1, $alpha2, $k, $N0, $N1, $alpha_opt, $alpha22, $T1){
    $D1 = $p * N_before_T1($T1, $alpha1, $alpha2, $k, $N0);
    $D2 = $p * N_after_T1(1, $T1, $alpha_opt, $alpha22, $k, $N0, $N1);
    return $D1 + $D2;
}

function profit_both($p, $alpha1, $alpha2, $k, $N0, $N1, $alpha_opt, $alpha22, $T1, $s){
    $P1 = income_first($p, $alpha1, $alpha2, $k, $N0) - sum_spend_first($s, $alpha1);
    $P2 = income_second($p, $alpha1, $alpha2, $k, $N0, $N1, $alpha_opt, $alpha22, $T1) - sum_spend_second($s, $alpha1, $T1, $alpha_opt);
    return array($P1, $P2);
}
