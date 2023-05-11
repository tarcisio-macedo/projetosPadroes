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
        $dirArquivoJson = $this->encontrarUltimoArquivoModificado($dirJson);
        
        $nomeArquivoJson = substr($dirArquivoJson, strrpos($dirArquivoJson, "/") + 1);

        $nomeArquivoXlsx = str_replace(".json", ".xlsx", $nomeArquivoJson);
        $dirPasta = substr($dirArquivoJson, 0, strrpos($dirArquivoJson, "/"));
        $dirPastaXlsx = substr($dirArquivoJson, 0, strrpos($dirPasta, "/")) . "/xlsx" . "/";

        $dirArquivoXlsx = $dirPastaXlsx . $nomeArquivoXlsx;

        $json = file_get_contents($dirArquivoJson);
        $array = json_decode($json, true);
        
        $colunas = [];
    
        $primeiroRegistro = [];
        
        foreach ($array as $registro)
        {
            $primeiroRegistro = $registro;
            break;
        }
    
        $colunas = array_flip(array_keys($primeiroRegistro));
        
        foreach ($colunas as $nome => $id)
        {
            $letraColuna = $this->converterNumeroEmLetra($id + 1);
            $colunas[$nome] = $letraColuna;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Planilha');

        $linha = 1;


        $ultColuna = '';
        foreach ($colunas as $nomeColuna => $letra)
        {
            $sheet->setCellValue($letra . '1', $nomeColuna);
            $ultColuna = $letra;
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


        // Congelar a primeira linha 
        $sheet->freezePane('A2');

        
        $fontStyle =
        [
            'font' =>
            [
                'size' => 10
            ],
            'alignment' =>
            [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            ],
        ];

        $sheet->getStyle("A1:" . $ultColuna . $linha)->applyFromArray($fontStyle);


        $writer = new Xlsx($spreadsheet);
        $writer->save($dirArquivoXlsx);

        echo 'Convertido' . PHP_EOL;
        echo 'Ver arquivo: ' . $dirArquivoXlsx . PHP_EOL;
    }

    function encontrarUltimoArquivoModificado($dir)
    {
        $arquivos = scandir($dir);
        $ultimoArquivoModificado = '';
        $dataModificacaoMaisRecente = 0;

        foreach ($arquivos as $arquivo)
        {
            $caminhoCompleto = $dir . $arquivo;

            if (is_file($caminhoCompleto))
            {
                $dataModificacao = filemtime($caminhoCompleto);

                if ($dataModificacao > $dataModificacaoMaisRecente)
                {
                    $dataModificacaoMaisRecente = $dataModificacao;
                    $ultimoArquivoModificado = $caminhoCompleto;
                }
            }
        }

        $dirArquivoJson = $ultimoArquivoModificado;
        return $dirArquivoJson;
    }
}