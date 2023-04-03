<?php

namespace Tarcisio\ProjetosPadroes\php\_outros;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// $dirArquivoPlanilhaOrigem = ''; // Arquivo XLSX
// $classe = new formatarPlanilha($dirArquivoPlanilhaOrigem, '', 'G', false, true);
// $classe = new formatarPlanilha($dirArquivoPlanilhaOrigem, '', 'G', true, true);
// $classe->formatar();

class formatarPlanilha
{
    use formatacaoTexto;

    public string $dirArquivoPlanilhaOrigem;
    public string $dirArquivoPlanilhaDestino;
    public string $guia;
    public array $colunas;
    public bool $subscrever;
    public bool $retirarTagsHTML;
    public bool $converterCRLF;


    function __construct($dirArquivoPlanilhaOrigem, $guia, array $colunas, bool $subscrever, bool $retirarTagsHTML, bool $converterCRLF)
    {
        $this->dirArquivoPlanilhaOrigem = $dirArquivoPlanilhaOrigem;
        $this->guia = $guia;
        $this->colunas = $colunas;
        $this->subscrever = $subscrever;
        $this->retirarTagsHTML = $retirarTagsHTML;
        $this->converterCRLF = $converterCRLF;

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
                

                foreach ($this->colunas as $coluna)
                {
                    for ($linha=2; $linha < $ultLinha; $linha++)
                    {
                        $celula = $coluna . $linha;
                        $textoCelulaOriginal = $sheet->getCell($celula)->getValue();
    
                        $textoAuxiliar = $textoCelulaOriginal;
    
                        if ($this->retirarTagsHTML)
                        {
                            // $textoCelulaFormatado = $this->formatarTexto($textoAuxiliar);
                            $textoAuxiliar = $this->retirarTagsHTML($textoAuxiliar);
                        }
                        if ($this->converterCRLF)
                        {
                            $textoAuxiliar = $this->converterCRLF($textoAuxiliar);
                        }
                        
                        $textoAuxiliar = $this->formatarTexto($textoAuxiliar);
    
                        if ($textoCelulaOriginal != $textoAuxiliar)
                        {
                            $sheet->setCellValue($celula, $textoAuxiliar);
                        }
                    }
                }

                $writer = new Xlsx($spreadsheet);
                $writer->save($this->dirArquivoPlanilhaDestino);
                
                echo 'Formatado' . PHP_EOL;
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