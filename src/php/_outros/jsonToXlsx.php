<?php

namespace Tarcisio\ProjetosPadroes\php\_outros;

use DateTime;
use DateTimeZone;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tarcisio\ProjetosPadroes\php\_outros\formatacaoTexto;


class jsonToXlsx
{
    use formatacaoTexto;

    function __construct()
    {
        ini_set('memory_limit', '2048M');
    }

    function converterJSONParaXlsx($dirJson, $modo)
    {
        // modo 'todos', 'ultimo'

        if ($modo == 'todos')
        {
            $arquivos = scandir($dirJson);
    
            foreach ($arquivos as $arquivo)
            {
                $caminhoCompleto = $dirJson . $arquivo;
    
                if (is_file($caminhoCompleto))
                {
                    $this->gerarPlanilha($caminhoCompleto);
                }
            }
        }
        if ($modo == 'ultimo')
        {
            $dirArquivoJson = $this->encontrarUltimoArquivoModificado($dirJson);
            $this->gerarPlanilha($dirArquivoJson);
            // $this->gerarPlanilha2($dirArquivoJson);
        }

        echo "Concluído!" . PHP_EOL;
    }

    function gerarPlanilha($dirCaminho)
    {
        $dirArquivoJson = $dirCaminho;

        $dataModificacao = filemtime($dirArquivoJson);
        $dateTime = new DateTime();
        $dateTime->setTimestamp($dataModificacao);
        $timezone = new DateTimeZone('America/Sao_Paulo');
        $dateTime->setTimezone($timezone);
        $dataModificacao = $dateTime->format('Y-m-d H_i');

        
        $dirPasta = substr($dirArquivoJson, 0, strrpos($dirArquivoJson, "/"));

        $nomeArquivoJson = substr($dirArquivoJson, strrpos($dirArquivoJson, "/") + 1);
        $nomeArquivoJsonHistorico = str_replace(".json", " ($dataModificacao).json", $nomeArquivoJson);

        $nomeArquivoXlsx = str_replace(".json", ".xlsx", $nomeArquivoJsonHistorico);

        $dirPastaXlsx = substr($dirArquivoJson, 0, strrpos($dirPasta, "/")) . "/xlsx" . "/";
        $dirArquivoXlsx = $dirPastaXlsx . $nomeArquivoXlsx;

        $dirPastaXlsxHistorico = substr($dirArquivoJson, 0, strrpos($dirPasta, "/")) . "/xlsxHistorico" . "/";
        $dirArquivoXlsxHistorico = $dirPastaXlsxHistorico . $nomeArquivoXlsx;

        $dirPastaJsonHistorico = substr($dirArquivoJson, 0, strrpos($dirPasta, "/")) . "/jsonHistorico" . "/";
        $dirArquivoJsonHistorico = $dirPastaJsonHistorico . $nomeArquivoJsonHistorico;


        echo 'Iniciado: ' . $dirArquivoXlsxHistorico . PHP_EOL;

        // Transferir para Json Histórico
        $json = file_get_contents($dirArquivoJson);
        $array = json_decode($json, true);
        $json = json_encode($array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        file_put_contents($dirArquivoJsonHistorico, $json);
        $json = null;



        // Criar a planilha
        // $json = file_get_contents($dirArquivoJsonHistorico);
        // $array = json_decode($json, true);
        



        // Primeiro Registro
        $primeiroRegistro = [];
        
        foreach ($array as $registro)
        {
            $primeiroRegistro = $registro;
            break;
        }
    
        $primeiraColunaPlanilha = array_key_first($primeiroRegistro);

        
        $colunasJSON = [];
        
        $guias['Planilha'] =
        [
            'linha' => 1,
            'ultColuna' => null
        ];

        foreach ($primeiroRegistro as $id => $valor)
        {
            if ($valor != null)
            {
                if (substr($valor, 0, 1) == "[")
                {
                    $colunasJSON[] = $id;

                    $guias[$id] =
                    [
                        'linha' => 1,
                        'ultColuna' => null
                    ];
                }
            }
        }


        $colunasPlanilha = [];
        $colunasPlanilha = array_flip(array_keys($primeiroRegistro));
        
        foreach ($colunasPlanilha as $nome => $id)
        {
            $letraColuna = $this->converterNumeroEmLetra($id + 1);
            $colunasPlanilha[$nome] = $letraColuna;
            $guias['Planilha']['ultColuna'] = $letraColuna;
        }

        

        // Criar planilha
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Planilha');

        // Adicionar Guias Json
        foreach ($colunasJSON as $colunaJSON)
        {
            $newSheet = new Worksheet();
            $newSheet->setTitle($colunaJSON);
            $newSheet->setCellValue('A1', $primeiraColunaPlanilha);
            $spreadsheet->addSheet($newSheet);
        }



        // Preencher Nome das Colunas
        foreach ($colunasPlanilha as $nomeColuna => $letra)
        {
            $sheet->setCellValue($letra . '1', $nomeColuna);
            $guias['Planilha']['ultColuna'] = $letra;
        }
        


        // Preencher as linhas em cada guia
        $registros = $array;

        foreach ($registros as $registro)
        {
            foreach ($guias as $nomeGuia => $guia)
            {
                $numLinhaGuia = $guia['linha'];
                $ultColunaGuia = $guia['ultColuna'];

                $linha = $numLinhaGuia;

                if (!in_array($nomeGuia, $colunasJSON))
                {
                    $linha++;
                    $sheet = $spreadsheet->setActiveSheetIndexByName($nomeGuia);
                    
                    $colunasRegistro = $registro;

                    foreach ($colunasRegistro as $nomeColunaRegistro => $valor)
                    {
                        if (!in_array($nomeColunaRegistro, $colunasJSON))
                        {
                            $letraColuna = $colunasPlanilha[$nomeColunaRegistro];
                            $sheet->setCellValue($letraColuna . $linha, $valor);
                        }
                        else
                        {
                            $letraColuna = $colunasPlanilha[$nomeColunaRegistro];
                            $sheet->setCellValue($letraColuna . $linha, 'Ver Guia: ' . $nomeColunaRegistro);
                        }

                        $guias[$nomeGuia]['ultColuna'] = $letraColuna;
                    }
                }
                else
                {
                    $valorPrimeiraColunaPlanilha = $registro[$primeiraColunaPlanilha];

                    $colunaRegistro = $registro[$nomeGuia];

                    if ($colunaRegistro !== null && $colunaRegistro !== '[]')
                    {
                        $registrosColunaJson = json_decode($colunaRegistro, true);
                        
                        if (count($registrosColunaJson) > 0)
                        {
                            $sheet = $spreadsheet->setActiveSheetIndexByName($nomeGuia);
                            
                            foreach ($registrosColunaJson as $indexRegistroColunaJson => $registroColunaJson)
                            {
                                $linha++;
                                
                                $indexColuna = 1;
                                $letraColuna = $this->converterNumeroEmLetra($indexColuna);
                                $sheet->setCellValue($letraColuna . $linha, $valorPrimeiraColunaPlanilha);
                                
                                if (gettype($registroColunaJson) == 'string')
                                {
                                    $indexColuna++;
                                    $letraColuna = $this->converterNumeroEmLetra($indexColuna);
                                    $sheet->setCellValue($letraColuna . '1', 'id_JSON');
                                    $sheet->setCellValue($letraColuna . $linha, $registroColunaJson);
                                    $guias[$nomeGuia]['ultColuna'] = $letraColuna;
                                }
                                else
                                {
                                    foreach ($registroColunaJson as $nomeRegistroColunaJson => $valor)
                                    {
                                        $indexColuna++;
                                        $letraColuna = $this->converterNumeroEmLetra($indexColuna);
                                        $sheet->setCellValue($letraColuna . '1', $nomeRegistroColunaJson . '_JSON');
                                        $sheet->setCellValue($letraColuna . $linha, $valor);
                                        $guias[$nomeGuia]['ultColuna'] = $letraColuna;
                                    }
                                }
                            }
                        }
                    }
                }
                
                $guias[$nomeGuia]['linha'] = $linha;
            }
        }


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

        foreach ($guias as $nomeGuia => $guia)
        {
            $numLinhaGuia = $guia['linha'];
            $ultColunaGuia = $guia['ultColuna'];
            $sheet = $spreadsheet->setActiveSheetIndexByName($nomeGuia);
            $sheet->freezePane('A2');

            if ($ultColunaGuia != null)
            {
                $sheet->getStyle("A1:" . $ultColunaGuia . $numLinhaGuia)->applyFromArray($fontStyle);
            }
        }

        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        $writer->save($dirArquivoXlsxHistorico);

        $array = null;

        echo 'Finalizado!' . PHP_EOL;
    }

    function gerarPlanilha2($dirCaminho)
    {
        $dirArquivoJson = $dirCaminho;

        $dataModificacao = filemtime($dirArquivoJson);
        $dateTime = new DateTime();
        $dateTime->setTimestamp($dataModificacao);
        $timezone = new DateTimeZone('America/Sao_Paulo');
        $dateTime->setTimezone($timezone);
        $dataModificacao = $dateTime->format('Y-m-d H_i');

        
        $dirPasta = substr($dirArquivoJson, 0, strrpos($dirArquivoJson, "/"));

        $nomeArquivoJson = substr($dirArquivoJson, strrpos($dirArquivoJson, "/") + 1);
        $nomeArquivoJsonHistorico = str_replace(".json", " ($dataModificacao).json", $nomeArquivoJson);

        $nomeArquivoXlsx = str_replace(".json", ".xlsx", $nomeArquivoJsonHistorico);

        $dirPastaXlsx = substr($dirArquivoJson, 0, strrpos($dirPasta, "/")) . "/xlsx" . "/";
        $dirArquivoXlsx = $dirPastaXlsx . $nomeArquivoXlsx;

        $dirPastaXlsxHistorico = substr($dirArquivoJson, 0, strrpos($dirPasta, "/")) . "/xlsxHistorico" . "/";
        $dirArquivoXlsxHistorico = $dirPastaXlsxHistorico . $nomeArquivoXlsx;

        $dirPastaJsonHistorico = substr($dirArquivoJson, 0, strrpos($dirPasta, "/")) . "/jsonHistorico" . "/";
        $dirArquivoJsonHistorico = $dirPastaJsonHistorico . $nomeArquivoJsonHistorico;



        // Transferir para Json Histórico
        $json = file_get_contents($dirArquivoJson);
        $array = json_decode($json, true);
        $json = json_encode($array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        file_put_contents($dirArquivoJsonHistorico, $json);
        $json = null;



        // Criar a planilha
        // $json = file_get_contents($dirArquivoJsonHistorico);
        // $array = json_decode($json, true);

        
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
        // $writer->save($dirArquivoXlsx);
        $writer->save($dirArquivoXlsxHistorico);

        
        // echo 'Convertido: ' . $dirArquivoXlsx . PHP_EOL;
        echo 'Convertido: ' . str_replace('/', "\\", $dirArquivoXlsxHistorico) . PHP_EOL;
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