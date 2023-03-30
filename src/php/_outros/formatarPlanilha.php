<?php

namespace Tarcisio\ProjetosPadroes\php\_outros;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// $dirArquivoPlanilhaOrigem = ''; // Arquivo XLSX
// $classe = new formatarPlanilha($dirArquivoPlanilhaOrigem, '', 'G', false);
// $classe = new formatarPlanilha($dirArquivoPlanilhaOrigem, '', 'G', true);
// $classe->formatar();

class formatarPlanilha
{
    use formatacaoTexto;

    public string $dirArquivoPlanilhaOrigem;
    public string $dirArquivoPlanilhaDestino;
    public string $guia;
    public string $coluna;
    public string $subscrever;

    function __construct($dirArquivoPlanilhaOrigem, $guia, $coluna, bool $subscrever)
    {
        $this->dirArquivoPlanilhaOrigem = $dirArquivoPlanilhaOrigem;
        $this->guia = $guia;
        $this->coluna = $coluna;
        $this->subscrever = $subscrever;

        if ($this->subscrever)
        {
            $this->dirArquivoPlanilhaDestino = $this->dirArquivoPlanilhaOrigem;
        }
        else
        {
            $this->dirArquivoPlanilhaDestino = str_replace('.xlsx', '', $this->dirArquivoPlanilhaOrigem) . '_formatado.xlsx';
        }
    }

    function formatar()
    {
        if (file_exists($this->dirArquivoPlanilhaOrigem))
        {
            if (str_contains($this->dirArquivoPlanilhaOrigem, ".xlsx"))
            {
                $spreadsheet = IOFactory::load($this->dirArquivoPlanilhaOrigem);
    
                if (empty($this->guia) && $this->guia != null)
                {
                    $sheet = $spreadsheet->getSheetByName($this->guia);
                }
                else
                {
                    $sheet = $spreadsheet->getActiveSheet();
                }
                
                $ultLinha = $sheet->getHighestRow();
    
                for ($linha=2; $linha < $ultLinha; $linha++)
                {
                    $celula = $this->coluna . $linha;
                    $textoCelulaOriginal = $sheet->getCell($celula)->getValue();
                    $textoCelulaFormatado = $this->formatarTexto($textoCelulaOriginal);
                    
                    if ($textoCelulaOriginal != $textoCelulaFormatado)
                    {
                        $sheet->setCellValue($celula, $textoCelulaFormatado);
                    }
                }
    
                $writer = new Xlsx($spreadsheet);
                $writer->save($this->dirArquivoPlanilhaDestino);
            }
            else
            {
                echo 'Arquivo não é planilha' . PHP_EOL;
            }
        }
        else
        {
            echo 'Arquivo não existe' . PHP_EOL;
        }
    }
}