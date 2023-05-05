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
}