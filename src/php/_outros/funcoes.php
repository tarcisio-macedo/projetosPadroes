<?php

namespace Tarcisio\ProjetosPadroes\php\_outros; 

use DateTime;


// // CLASS
// $funcoes = new funcoes();
// var_dump($funcoes->checarSeEData('28/12/2022 00:00:00'));

// // TRAIT
// use funcoes;
// var_dump($this->checarSeEData('28/12/2022 00:00:00'));

trait funcoes
{
    function checarSeEData($date)
    {
        $formato = 'Y-m-d H:i:s';
        $d = DateTime::createFromFormat($formato, $date);
        
        if ($d && $d->format($formato) == $date)
        {
            return true;
        }
        
        $formato = 'd/m/Y H:i:s';
        $d = DateTime::createFromFormat($formato, $date);
        
        if ($d && $d->format($formato) == $date)
        {
            return true;
        }
        
        $formato = 'Y-m-d';
        $d = DateTime::createFromFormat($formato, $date);
        
        if ($d && $d->format($formato) == $date)
        {
            return true;
        }
        
        $formato = 'd/m/Y';
        $d = DateTime::createFromFormat($formato, $date);
        
        if ($d && $d->format($formato) == $date)
        {
            return true;
        }

        return false;
    }
    
    function checarSeEDataETipo($date)
    {
        $formato = 'Y-m-d H:i:s';
        $d = DateTime::createFromFormat($formato, $date);
        
        if ($d && $d->format($formato) == $date)
        {
            $array =
            [
                'tipo' => 'data',
                'formato' => $formato
            ];

            return $array;
        }
        
        $formato = 'd/m/Y H:i:s';
        $d = DateTime::createFromFormat($formato, $date);
        
        if ($d && $d->format($formato) == $date)
        {
            $array =
            [
                'tipo' => 'data',
                'formato' => $formato
            ];

            return $array;
        }
        
        $formato = 'Y-m-d';
        $d = DateTime::createFromFormat($formato, $date);
        
        if ($d && $d->format($formato) == $date)
        {
            $array =
            [
                'tipo' => 'data',
                'formato' => $formato
            ];

            return $array;
        }
        
        $formato = 'd/m/Y';
        $d = DateTime::createFromFormat($formato, $date);
        
        if ($d && $d->format($formato) == $date)
        {
            $array =
            [
                'tipo' => 'data',
                'formato' => $formato
            ];

            return $array;
        }

        return false;
    }
    
    function converterDataAmericPort(string $dataString): string
    {
        $dataFinal = 'Sem data';
        
        $eData = $this->checarSeEData($dataString);
        
        if ($eData)
        {
            $data = date('D', strtotime($dataString));
            $mes = date('M', strtotime($dataString));
            $dia = date('d', strtotime($dataString));
            $ano = date('Y', strtotime($dataString));
    
            $semana = array(
                'Sun' => 'Domingo',
                'Mon' => 'Segunda-Feira',
                'Tue' => 'Terca-Feira',
                'Wed' => 'Quarta-Feira',
                'Thu' => 'Quinta-Feira',
                'Fri' => 'Sexta-Feira',
                'Sat' => 'Sábado'
            );
    
            $mes_extenso = array(
                'Jan' => 'Janeiro',
                'Feb' => 'Fevereiro',
                'Mar' => 'Março',
                'Apr' => 'Abril',
                'May' => 'Maio',
                'Jun' => 'Junho',
                'Jul' => 'Julho',
                'Aug' => 'Agosto',
                'Nov' => 'Novembro',
                'Sep' => 'Setembro',
                'Oct' => 'Outubro',
                'Dec' => 'Dezembro'
            );
    
            // $dataExtenso = ucfirst($semana[$data]) . ", {$dia} de " . ucfirst($mes_extenso["$mes"]) . " de {$ano}";
            // $data1 = ucfirst($mes_extenso[$mes]) . "/". $ano;
            $data2 = mb_strtoupper(substr($mes_extenso[$mes], 0, 3)) . "/". $ano;
    
            $dataFinal = $data2;
        }

        return $dataFinal;
    }
}