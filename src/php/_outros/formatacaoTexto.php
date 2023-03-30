<?php

namespace Tarcisio\ProjetosPadroes\php\_outros;

// use Tarcisio\ProjetosPadroes\php\_outros\formatacaoTexto;
// use formatacaoTexto;
// $textoAuxiliar = $this->formatarTexto($textoOriginal);

// class formatacaoTexto
trait formatacaoTexto
{
    function formatarTexto($textoOriginal)
    {
        $textoAuxiliar = $textoOriginal;
        
        if (!empty($textoAuxiliar) && $textoAuxiliar != null)
        {
            if (str_contains($textoAuxiliar, "\r\n"))
            {
                $textoAuxiliar = str_replace("\r\n", "\n", $textoAuxiliar);
            }
            if (str_contains($textoAuxiliar, "\r"))
            {
                $textoAuxiliar = str_replace("\r", "\n", $textoAuxiliar);
            }
            if (str_contains($textoAuxiliar, "_x000D_"))
            {
                $textoAuxiliar = str_replace("_x000D_", '', $textoAuxiliar);
            }

            // Retirar 2 ou mais espaços na string
            while (str_contains($textoAuxiliar, ' ' . ' ')) {
                // echo 'Retirou 2 ou mais espaços na string' . "\n";
                $textoAuxiliar = str_replace(' ' . ' ', ' ', $textoAuxiliar);
            }
            
            // Retirar espaço no inicio da linha
            while (str_contains($textoAuxiliar, "\n" . ' ')) {
                // echo 'Retirou espaço no inicio da linha' . "\n";
                $textoAuxiliar = str_replace("\n" . ' ', "\n", $textoAuxiliar);
            }
            
            // Retirar espaço no final da linha
            while (str_contains($textoAuxiliar, ' ' . "\n")) {
                // echo 'Retirou espaço no final da linha' . "\n";
                $textoAuxiliar = str_replace(' ' . "\n", "\n", $textoAuxiliar);
            }

            // Retirar espaço entre duas quebras de linha
            while (str_contains($textoAuxiliar, "\n" . ' ' . "\n")) {
                // echo 'Retirou espaço entre duas quebras de linha' . "\n";
                $textoAuxiliar = str_replace("\n" . ' ' . "\n", "\n" . "\n", $textoAuxiliar);
            }
            
            // Retirar 3 ou mais quebras de linha
            while (str_contains($textoAuxiliar, "\n" . "\n" . "\n")) {
                // echo 'Retirou 3 ou mais quebras de linha' . "\n";
                $textoAuxiliar = str_replace("\n" . "\n" . "\n", "\n" . "\n", $textoAuxiliar);
            }
            
            // Retirar quebra de linha no inicio da string
            while (substr($textoAuxiliar, 0, strlen("\n")) === "\n") {
                // echo 'Retirou quebra de linha no inicio da string' . "\n";
                $textoAuxiliar = substr($textoAuxiliar, strlen("\n"));
            }
            
            // Retirar quebra de linha no final da string
            while (substr($textoAuxiliar, -strlen("\n"), strlen("\n")) === "\n") {
                // echo 'Retirou quebra de linha no final da string' . "\n";
                $textoAuxiliar = substr($textoAuxiliar, 0, -strlen("\n"));
            }

            $textoAuxiliar = str_replace("—", "-", $textoAuxiliar);
            $textoAuxiliar = str_replace("–", "-", $textoAuxiliar);
            $textoAuxiliar = str_replace('“', "\"", $textoAuxiliar);
            $textoAuxiliar = str_replace('”', "\"", $textoAuxiliar);
            $textoAuxiliar = str_replace('°', "º", $textoAuxiliar);
            $textoAuxiliar = str_replace('’', "'", $textoAuxiliar);
        }

        $resultado = $textoAuxiliar;
        return $resultado;
    }

    function separarPorQuebraDeLinha($conteudo): mixed
    {
        if (gettype($conteudo) == 'string')
        {
            return explode("\n", $conteudo);
        }
        elseif (gettype($conteudo) == 'array')
        {
            $array = $conteudo;

            foreach($array as $index => $item)
            {
                $array[$index] = explode("\n", $item);
            }

            return $array;
        }
        else
        {
            return $conteudo;
        }
    }

    function unirTextoPorQuebraDeLinha(array $conteudo): string
    {
        return implode("\n", $conteudo);
    }

    // Converte numero em letra
    function converterNumeroEmLetra($num)
    {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return $this->converterNumeroEmLetra($num2) . $letter;
        } else {
            return $letter;
        }
    }

    function retirarTagsHTML($textoOriginal)
    {
        $texto = $textoOriginal;
        
        if (!empty($texto) && $texto != null)
        {
            if (str_contains($texto, "&lt;") && str_contains($texto, "&gt;"))
            {
                $texto = str_replace(str_replace($texto, "&lt;", "<"), "&gt;", ">");
            }

            if (str_contains($texto, "<") && str_contains($texto, ">"))
            {
                if ($texto != "<Vazio>")
                {
                    $texto = str_replace("<p>", "<p>" . "<br>", $texto);
                    $texto = str_replace("</p>", "</p>" . "<br>", $texto);
                    $texto = str_replace("</td><td ", "</td>" . "<p>&nbsp;-&nbsp;</p>" . "<td ", $texto);
                    $texto = str_replace("<br />", "<br>", $texto);
                    $textoConvertido = strip_tags($texto);

                    $texto = $textoConvertido;
                }
            }
        }
        
        // if (!string.IsNullOrEmpty($texto)) {
        
        if (!empty($texto) && $texto != null)
        {
            $texto = str_replace($texto, "&nbsp;", " ");

            $texto = str_replace($texto, "&#193;", "Á");
            $texto = str_replace($texto, "&Aacute;", "Á");
            $texto = str_replace($texto, "&aacute;", "á");
            
            $texto = str_replace($texto, "&#192;", "À");
            $texto = str_replace($texto, "&Agrave;", "À");
            $texto = str_replace($texto, "&agrave;", "à");
            $texto = str_replace($texto, "&#195;", "Ã");
            $texto = str_replace($texto, "&Atilde;", "Ã");
            $texto = str_replace($texto, "&atilde;", "ã");
            $texto = str_replace($texto, "&#194;", "Â");
            $texto = str_replace($texto, "&Aacute;", "Â");
            $texto = str_replace($texto, "&acirc;", "â");

            $texto = str_replace($texto, "&#201;", "É");
            $texto = str_replace($texto, "&Eacute;", "É");
            $texto = str_replace($texto, "&eacute;", "é");
            $texto = str_replace($texto, "&#202;", "Ê");
            $texto = str_replace($texto, "&Ecirc;", "Ê");
            $texto = str_replace($texto, "&ecirc;", "ê");

            $texto = str_replace($texto, "&#205;", "Í");
            $texto = str_replace($texto, "&Iacute;", "Í");
            $texto = str_replace($texto, "&iacute;", "í");

            $texto = str_replace($texto, "&#212;", "Ô");
            $texto = str_replace($texto, "&Ocirc;", "Ô");
            $texto = str_replace($texto, "&ocirc;", "ô");
            $texto = str_replace($texto, "&#213;", "Õ");
            $texto = str_replace($texto, "&Otilde;", "Õ");
            $texto = str_replace($texto, "&otilde;", "õ");
            $texto = str_replace($texto, "&#211;", "Ó");
            $texto = str_replace($texto, "&Oacute;", "Ó");
            $texto = str_replace($texto, "&oacute;", "ó");
            
            $texto = str_replace($texto, "&#218;", "Ú");
            $texto = str_replace($texto, "&Uacute;", "Ú");
            $texto = str_replace($texto, "&uacute;", "ú");
            
            $texto = str_replace($texto, "&#220;", "Ü");
            $texto = str_replace($texto, "&Uuml;", "Ü");
            $texto = str_replace($texto, "&uuml;", "ü");



            $texto = str_replace($texto, "&#199;", "Ç");
            $texto = str_replace($texto, "&Ccedil;", "Ç");
            $texto = str_replace($texto, "&ccedil;", "ç");

            $texto = str_replace($texto, "&ordf;", "ª");
            $texto = str_replace($texto, "&#170;", "ª");



            $texto = str_replace($texto, "&deg;", "º");
            $texto = str_replace($texto, "&#186;", "º");
            $texto = str_replace($texto, "&ordm;", "º");

            $texto = str_replace($texto, "&sect;", "§");
            
            $texto = str_replace($texto, "&ndash;", "-");

            $texto = str_replace($texto, "&rsquo;", "'");
            $texto = str_replace($texto, "&acute;", "'");
            
            
            $texto = str_replace($texto, "&ldquo;", "\"");
            $texto = str_replace($texto, "&rdquo;", "\"");
        }
        
        if ($texto == null)
        {
            $texto = "";
        }
        
        return $texto;
    }
}