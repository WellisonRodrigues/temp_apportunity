<?php
/**
 * Created by PhpStorm.
 * User: Wellison
 * Date: 29/10/2017
 * Time: 18:32
 */
//print_r($vagas_salvas);

foreach ($vagas_salvas as $vaga_salva){

    print_r($vaga_salva['relationships']['job']);
}
?>