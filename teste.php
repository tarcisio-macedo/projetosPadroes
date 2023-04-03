<?php

use Tarcisio\ProjetosPadroes\php\_outros\formatarPlanilha;

require_once 'vendor/autoload.php';

$dirArquivoPlanilhaOrigem = 'C:\Users\Tarcisio\Downloads\Clausulas dos documentos 97, 106 e 107.xlsx'; // Arquivo XLSX

$classe = new formatarPlanilha($dirArquivoPlanilhaOrigem, '', ['D', 'J'], false, false, true);
// $classe = new formatarPlanilha($dirArquivoPlanilhaOrigem, '', ['D', 'J'], true, false, true);

$classe->formatar();