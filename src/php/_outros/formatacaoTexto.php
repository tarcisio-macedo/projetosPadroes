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
            $textoAuxiliar = str_replace("­", "", $textoAuxiliar);

        }

        $textoAuxiliar = $this->correcaoErrosPalavras($textoAuxiliar);
        
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
        }
        
        if ($texto == null)
        {
            $texto = "";
        }
        
        return $texto;
    }

    function converterCaracteresHTMLEmCaracteresReais($textoOriginal)
    {
        $texto = $textoOriginal;

        $texto = html_entity_decode($texto);

        if (str_contains($texto, '&#'))
        {
            $texto = str_replace("&#173;", "­", $texto);
            $texto = str_replace("&#39;", "'", $texto);
            $texto = str_replace("&#45;", "-", $texto);
            $texto = str_replace("&#33;", "!", $texto);
            $texto = str_replace("&#34;", "\"", $texto);
            $texto = str_replace("&#35;", "#", $texto);
            $texto = str_replace("&#36;", "$", $texto);
            $texto = str_replace("&#37;", "%", $texto);
            $texto = str_replace("&#38;", "&", $texto);
            $texto = str_replace("&#40;", "(", $texto);
            $texto = str_replace("&#41;", ")", $texto);
            $texto = str_replace("&#42;", "*", $texto);
            $texto = str_replace("&#44;", ",", $texto);
            $texto = str_replace("&#46;", ".", $texto);
            $texto = str_replace("&#47;", "/", $texto);
            $texto = str_replace("&#58;", ":", $texto);
            $texto = str_replace("&#59;", ";", $texto);
            $texto = str_replace("&#63;", "?", $texto);
            $texto = str_replace("&#64;", "@", $texto);
            $texto = str_replace("&#91;", "[", $texto);
            $texto = str_replace("&#92;", "\\", $texto);
            $texto = str_replace("&#93;", "]", $texto);
            $texto = str_replace("&#95;", "_", $texto);
            $texto = str_replace("&#96;", "`", $texto);
            $texto = str_replace("&#123;", "{", $texto);
            $texto = str_replace("&#124;", "|", $texto);
            $texto = str_replace("&#125;", "}", $texto);
            $texto = str_replace("&#126;", "~", $texto);
            $texto = str_replace("&#161;", "¡", $texto);
            $texto = str_replace("&#166;", "¦", $texto);
            $texto = str_replace("&#168;", "¨", $texto);
            $texto = str_replace("&#175;", "¯", $texto);
            $texto = str_replace("&#180;", "´", $texto);
            $texto = str_replace("&#184;", "¸", $texto);
            $texto = str_replace("&#191;", "¿", $texto);
            $texto = str_replace("&#162;", "¢", $texto);
            $texto = str_replace("&#163;", "£", $texto);
            $texto = str_replace("&#164;", "¤", $texto);
            $texto = str_replace("&#165;", "¥", $texto);
            $texto = str_replace("&#43;", "+", $texto);
            $texto = str_replace("&#60;", "<", $texto);
            $texto = str_replace("&#61;", "=", $texto);
            $texto = str_replace("&#62;", ">", $texto);
            $texto = str_replace("&#177;", "±", $texto);
            $texto = str_replace("&#171;", "«", $texto);
            $texto = str_replace("&#187;", "»", $texto);
            $texto = str_replace("&#215;", "×", $texto);
            $texto = str_replace("&#247;", "÷", $texto);
            $texto = str_replace("&#167;", "§", $texto);
            $texto = str_replace("&#169;", "©", $texto);
            $texto = str_replace("&#172;", "¬", $texto);
            $texto = str_replace("&#174;", "®", $texto);
            $texto = str_replace("&#176;", "°", $texto);
            $texto = str_replace("&#181;", "µ", $texto);
            $texto = str_replace("&#182;", "¶", $texto);
            $texto = str_replace("&#183;", "·", $texto);
            $texto = str_replace("&#188;", "¼", $texto);
            $texto = str_replace("&#189;", "½", $texto);
            $texto = str_replace("&#190;", "¾", $texto);
            $texto = str_replace("&#185;", "¹", $texto);
            $texto = str_replace("&#178;", "²", $texto);
            $texto = str_replace("&#179;", "³", $texto);
            $texto = str_replace("&#170;", "ª", $texto);
            $texto = str_replace("&#193;", "Á", $texto);
            $texto = str_replace("&#225;", "á", $texto);
            $texto = str_replace("&#192;", "À", $texto);
            $texto = str_replace("&#224;", "à", $texto);
            $texto = str_replace("&#194;", "Â", $texto);
            $texto = str_replace("&#226;", "â", $texto);
            $texto = str_replace("&#197;", "Ä", $texto);
            $texto = str_replace("&#229;", "ä", $texto);
            $texto = str_replace("&#195;", "Ã", $texto);
            $texto = str_replace("&#227;", "ã", $texto);
            $texto = str_replace("&#196;", "Å", $texto);
            $texto = str_replace("&#228;", "å", $texto);
            $texto = str_replace("&#198;", "Æ", $texto);
            $texto = str_replace("&#230;", "æ", $texto);
            $texto = str_replace("&#199;", "Ç", $texto);
            $texto = str_replace("&#231;", "ç", $texto);
            $texto = str_replace("&#208;", "Ð", $texto);
            $texto = str_replace("&#240;", "ð", $texto);
            $texto = str_replace("&#201;", "É", $texto);
            $texto = str_replace("&#233;", "é", $texto);
            $texto = str_replace("&#200;", "È", $texto);
            $texto = str_replace("&#232;", "è", $texto);
            $texto = str_replace("&#202;", "Ê", $texto);
            $texto = str_replace("&#234;", "ê", $texto);
            $texto = str_replace("&#203;", "Ë", $texto);
            $texto = str_replace("&#235;", "ë", $texto);
            $texto = str_replace("&#205;", "Í", $texto);
            $texto = str_replace("&#237;", "í", $texto);
            $texto = str_replace("&#204;", "Ì", $texto);
            $texto = str_replace("&#236;", "ì", $texto);
            $texto = str_replace("&#206;", "Î", $texto);
            $texto = str_replace("&#238;", "î", $texto);
            $texto = str_replace("&#207;", "Ï", $texto);
            $texto = str_replace("&#239;", "ï", $texto);
            $texto = str_replace("&#209;", "Ñ", $texto);
            $texto = str_replace("&#241;", "ñ", $texto);
            $texto = str_replace("&#186;", "º", $texto);
            $texto = str_replace("&#211;", "Ó", $texto);
            $texto = str_replace("&#243;", "ó", $texto);
            $texto = str_replace("&#210;", "Ò", $texto);
            $texto = str_replace("&#242;", "ò", $texto);
            $texto = str_replace("&#212;", "Ô", $texto);
            $texto = str_replace("&#244;", "ô", $texto);
            $texto = str_replace("&#214;", "Ö", $texto);
            $texto = str_replace("&#246;", "ö", $texto);
            $texto = str_replace("&#213;", "Õ", $texto);
            $texto = str_replace("&#245;", "õ", $texto);
            $texto = str_replace("&#216;", "Ø", $texto);
            $texto = str_replace("&#248;", "ø", $texto);
            $texto = str_replace("&#223;", "ß", $texto);
            $texto = str_replace("&#222;", "Þ", $texto);
            $texto = str_replace("&#254;", "þ", $texto);
            $texto = str_replace("&#218;", "Ú", $texto);
            $texto = str_replace("&#250;", "ú", $texto);
            $texto = str_replace("&#217;", "Ù", $texto);
            $texto = str_replace("&#249;", "ù", $texto);
            $texto = str_replace("&#219;", "Û", $texto);
            $texto = str_replace("&#251;", "û", $texto);
            $texto = str_replace("&#220;", "Ü", $texto);
            $texto = str_replace("&#252;", "ü", $texto);
            $texto = str_replace("&#221;", "Ý", $texto);
            $texto = str_replace("&#253;", "ý", $texto);
            $texto = str_replace("&#254;", "ÿ", $texto);
            $texto = str_replace("&#160;", " ", $texto);
        }

        $texto = str_replace('&nbsp;', " ", $texto);
        $texto = str_replace("&Aacute;", "Á", $texto);
        $texto = str_replace("&aacute;", "á", $texto);
        $texto = str_replace("&Acirc;", "Â", $texto);
        $texto = str_replace("&acirc;", "â", $texto);
        $texto = str_replace("&acute;", "´", $texto);
        $texto = str_replace("&AElig;", "Æ", $texto);
        $texto = str_replace("&aelig;", "æ", $texto);
        $texto = str_replace("&Agrave;", "À", $texto);
        $texto = str_replace("&agrave;", "à", $texto);
        $texto = str_replace("&amp;", "&", $texto);
        $texto = str_replace("&Aring;", "Ä", $texto);
        $texto = str_replace("&Aring;", "Å", $texto);
        $texto = str_replace("&aring;", "å", $texto);
        $texto = str_replace("&Atilde;", "Ã", $texto);
        $texto = str_replace("&atilde;", "ã", $texto);
        $texto = str_replace("&brvbar;", "¦", $texto);
        $texto = str_replace("&Ccedil;", "Ç", $texto);
        $texto = str_replace("&ccedil;", "ç", $texto);
        $texto = str_replace("&cedil;", "¸", $texto);
        $texto = str_replace("&cent;", "¢", $texto);
        $texto = str_replace("&copy;", "©", $texto);
        $texto = str_replace("&curren;", "¤", $texto);
        $texto = str_replace("&deg;", "°", $texto);
        $texto = str_replace("&divide;", "÷", $texto);
        $texto = str_replace("&Eacute;", "É", $texto);
        $texto = str_replace("&eacute;", "é", $texto);
        $texto = str_replace("&ECirc;", "Ê", $texto);
        $texto = str_replace("&ecirc;", "ê", $texto);
        $texto = str_replace("&Egrave;", "È", $texto);
        $texto = str_replace("&egrave;", "è", $texto);
        $texto = str_replace("&ETH;", "Ð", $texto);
        $texto = str_replace("&eth;", "ð", $texto);
        $texto = str_replace("&Euml;", "Ë", $texto);
        $texto = str_replace("&euml;", "ë", $texto);
        $texto = str_replace("&frac12;", "½", $texto);
        $texto = str_replace("&frac14;", "¼", $texto);
        $texto = str_replace("&frac34;", "¾", $texto);
        $texto = str_replace("&gt;", ">", $texto);
        $texto = str_replace("&Iacute;", "Í", $texto);
        $texto = str_replace("&iacute;", "í", $texto);
        $texto = str_replace("&Icirc;", "Î", $texto);
        $texto = str_replace("&icirc;", "î", $texto);
        $texto = str_replace("&iexcl;", "¡", $texto);
        $texto = str_replace("&Igrave;", "Ì", $texto);
        $texto = str_replace("&igrave;", "ì", $texto);
        $texto = str_replace("&iquest;", "¿", $texto);
        $texto = str_replace("&Iuml;", "Ï", $texto);
        $texto = str_replace("&iuml;", "ï", $texto);
        $texto = str_replace("&laquo;", "«", $texto);
        $texto = str_replace("&lt;", "<", $texto);
        $texto = str_replace("&macr;", "¯", $texto);
        $texto = str_replace("&micro;", "µ", $texto);
        $texto = str_replace("&middot;", "·", $texto);
        $texto = str_replace("&nbsp;", " ", $texto);
        $texto = str_replace("&not;", "¬", $texto);
        $texto = str_replace("&Ntilde;", "Ñ", $texto);
        $texto = str_replace("&ntilde;", "ñ", $texto);
        $texto = str_replace("&Oacute;", "Ó", $texto);
        $texto = str_replace("&oacute;", "ó", $texto);
        $texto = str_replace("&Ocirc;", "Ô", $texto);
        $texto = str_replace("&ocirc;", "ô", $texto);
        $texto = str_replace("&Ograve;", "Ò", $texto);
        $texto = str_replace("&ograve;", "ò", $texto);
        $texto = str_replace("&ordf;", "ª", $texto);
        $texto = str_replace("&ordm;", "º", $texto);
        $texto = str_replace("&Oslash;", "Ø", $texto);
        $texto = str_replace("&oslash;", "ø", $texto);
        $texto = str_replace("&Otilde;", "Õ", $texto);
        $texto = str_replace("&otilde;", "õ", $texto);
        $texto = str_replace("&Ouml;", "Ö", $texto);
        $texto = str_replace("&ouml;", "ö", $texto);
        $texto = str_replace("&para;", "¶", $texto);
        $texto = str_replace("&plusmn;", "±", $texto);
        $texto = str_replace("&pound;", "£", $texto);
        $texto = str_replace("&quot;", "\"", $texto);
        $texto = str_replace("&raquo;", "»", $texto);
        $texto = str_replace("&reg;", "®", $texto);
        $texto = str_replace("&sect;", "§", $texto);
        $texto = str_replace("&shy;", "­", $texto);
        $texto = str_replace("&sup2;", "²", $texto);
        $texto = str_replace("&sup3;", "³", $texto);
        $texto = str_replace("&supl;", "¹", $texto);
        $texto = str_replace("&szlig;", "ß", $texto);
        $texto = str_replace("&THORN;", "Þ", $texto);
        $texto = str_replace("&thorn;", "þ", $texto);
        $texto = str_replace("&times;", "×", $texto);
        $texto = str_replace("&Uacute;", "Ú", $texto);
        $texto = str_replace("&uacute;", "ú", $texto);
        $texto = str_replace("&Ucirc;", "Û", $texto);
        $texto = str_replace("&ucirc;", "û", $texto);
        $texto = str_replace("&Ugrave;", "Ù", $texto);
        $texto = str_replace("&ugrave;", "ù", $texto);
        $texto = str_replace("&uml;", "¨", $texto);
        $texto = str_replace("&uml;", "ä", $texto);
        $texto = str_replace("&Uuml;", "Ü", $texto);
        $texto = str_replace("&uuml;", "ü", $texto);
        $texto = str_replace("&Yacute;", "Ý", $texto);
        $texto = str_replace("&yacute;", "ý", $texto);
        $texto = str_replace("&yen;", "¥", $texto);
        $texto = str_replace("&yuml;", "ÿ", $texto);
            
        return $texto;
    }

    function converterCRLF($textoOriginal)
    {
        $texto = $textoOriginal;
        
        if (!empty($texto) && $texto != null)
        {
            if (str_contains(strtolower($texto), "|crlf|"))
            {
                $texto = str_replace("|crlf|", "\n", str_replace("|CRLF|", "\n", $texto));
            }
        }
            
        if ($texto == null)
        {
            $texto = "";
        }
        
        return $texto;
    }

    function correcaoErrosPalavras($textoOriginal)
    {
        $texto = $textoOriginal;

        $texto = str_replace('CLAÚSULA', 'CLÁUSULA', $texto);
        $texto = str_replace('Claúsula', 'Cláusula', $texto);
        $texto = str_replace('CLAUSULA', 'CLÁUSULA', $texto);
        $texto = str_replace('Clausula', 'Cláusula', $texto);
        $texto = str_replace('CLÁSULA', 'CLÁUSULA', $texto);
        $texto = str_replace('Clásula', 'Cláusula', $texto);
        $texto = str_replace('CALUSULA', 'CLÁUSULA', $texto);
        $texto = str_replace('Calusula', 'Cláusula', $texto);
        
        return $texto;
    }
}