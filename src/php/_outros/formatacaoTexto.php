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
                $texto = str_replace("&gt;", ">", str_replace("&lt;", "<", $texto));
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
            $texto = $this->converterCaracteresHTMLEmCaracteresReais($texto);

            $texto = str_replace('&quot;', "\"", $texto);
            
            $texto = str_replace('&nbsp;', " ", $texto);

            $texto = str_replace("&#193;", "Á", $texto);
            $texto = str_replace("&Aacute;", "Á", $texto);
            $texto = str_replace("&aacute;", "á", $texto);
            
            $texto = str_replace("&#192;", "À", $texto);
            $texto = str_replace("&Agrave;", "À", $texto);
            $texto = str_replace("&agrave;", "à", $texto);
            $texto = str_replace("&#195;", "Ã", $texto);
            $texto = str_replace("&Atilde;", "Ã", $texto);
            $texto = str_replace("&atilde;", "ã", $texto);
            $texto = str_replace("&#194;", "Â", $texto);
            $texto = str_replace("&Aacute;", "Â", $texto);
            $texto = str_replace("&acirc;", "â", $texto);

            $texto = str_replace("&#201;", "É", $texto);
            $texto = str_replace("&Eacute;", "É", $texto);
            $texto = str_replace("&eacute;", "é", $texto);
            $texto = str_replace("&#202;", "Ê", $texto);
            $texto = str_replace("&Ecirc;", "Ê", $texto);
            $texto = str_replace("&ecirc;", "ê", $texto);

            $texto = str_replace("&#205;", "Í", $texto);
            $texto = str_replace("&Iacute;", "Í", $texto);
            $texto = str_replace("&iacute;", "í", $texto);

            $texto = str_replace("&#212;", "Ô", $texto);
            $texto = str_replace("&Ocirc;", "Ô", $texto);
            $texto = str_replace("&ocirc;", "ô", $texto);
            $texto = str_replace("&#213;", "Õ", $texto);
            $texto = str_replace("&Otilde;", "Õ", $texto);
            $texto = str_replace("&otilde;", "õ", $texto);
            $texto = str_replace("&#211;", "Ó", $texto);
            $texto = str_replace("&Oacute;", "Ó", $texto);
            $texto = str_replace("&oacute;", "ó", $texto);
            
            $texto = str_replace("&#218;", "Ú", $texto);
            $texto = str_replace("&Uacute;", "Ú", $texto);
            $texto = str_replace("&uacute;", "ú", $texto);
            
            $texto = str_replace("&#220;", "Ü", $texto);
            $texto = str_replace("&Uuml;", "Ü", $texto);
            $texto = str_replace("&uuml;", "ü", $texto);



            $texto = str_replace("&#199;", "Ç", $texto);
            $texto = str_replace("&Ccedil;", "Ç", $texto);
            $texto = str_replace("&ccedil;", "ç", $texto);

            $texto = str_replace("&ordf;", "ª", $texto);
            $texto = str_replace("&#170;", "ª", $texto);



            $texto = str_replace("&deg;", "º", $texto);
            $texto = str_replace("&#186;", "º", $texto);
            $texto = str_replace("&ordm;", "º", $texto);

            $texto = str_replace("&sect;", "§", $texto);
            
            $texto = str_replace("&ndash;", "-", $texto);

            $texto = str_replace("&rsquo;", "'", $texto);
            $texto = str_replace("&acute;", "'", $texto);
            
            
            $texto = str_replace("&ldquo;", "\"", $texto);
            // $texto = str_replace("&rdquo;", "\"", $texto);
        }
        
        if ($texto == null)
        {
            $texto = "";
        }
        
        return $texto;
    }

    function converterCaracteresHTMLEmCaracteresReais($textoOriginal)
    {
        return html_entity_decode($textoOriginal);
    }

    function converterCRLF($textoOriginal)
    {
        $texto = $textoOriginal;
        
        if (!empty($texto) && $texto != null)
        {
            if (str_contains(strtolower($texto), "|crlf|"))
            {
                $texto = str_replace("|crlf|", "\n", str_replace("|CRLF|", "\n",$texto));
            }
        }
            
        if ($texto == null)
        {
            $texto = "";
        }
        
        return $texto;
    }
}