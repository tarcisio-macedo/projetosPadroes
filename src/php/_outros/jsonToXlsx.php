<?php

namespace Tarcisio\ProjetosPadroes\php\_outros;

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tarcisio\ProjetosPadroes\php\_outros\formatacaoTexto;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


class jsonToXlsx
{
    use formatacaoTexto;

    function converterJSONParaXlsx($dirJson)
    {
        $nomeArquivoJson = substr($dirJson, strrpos($dirJson, "/") + 1); 

        $nomeArquivoXlsx = str_replace(".json", ".xlsx", $nomeArquivoJson);
        $dirPasta = substr($dirJson, 0, strrpos($dirJson, "/"));
        $dirPastaXlsx = substr($dirJson, 0, strrpos($dirPasta, "/")) . "/xlsx" . "/";

        $dirArquivoXlsx = $dirPastaXlsx . $nomeArquivoXlsx;

        $json = file_get_contents($dirJson);
        $array = json_decode($json, true);    
        $colunas = [];
    
        $primeiroRegistro = $array[0];
    
        $colunas = array_flip(array_keys($primeiroRegistro));
        
        foreach ($colunas as $nome => $id)
        {
            $letraColuna = $this->converterNumeroEmLetra($id + 1);
            $colunas[$nome] = $letraColuna;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $linha = 1;

        foreach ($colunas as $nomeColuna => $letra)
        {
            $sheet->setCellValue($letra . '1', $nomeColuna);
        }

        $registros = $array;

        foreach ($registros as $registro)
        {
            $linha++;
            $colunasRegistro = $registro;

            foreach ($colunasRegistro as $nomeColunaRegistro => $valor)
            {
                $letra = $colunas[$nomeColunaRegistro];
                $sheet->setCellValue($letra . $linha, $valor);
            }
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($dirArquivoXlsx);

        echo 'Convertido' . PHP_EOL;
        echo 'Ver arquivo: ' . $dirArquivoXlsx . PHP_EOL;
    }
}