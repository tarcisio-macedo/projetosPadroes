<?php

namespace Tarcisio\ProjetosPadroes\php\_outros;

class diretorios
{
    public string $dirRaiz;
    public string $dirVendor;
    public string $dirSrc;
    public string $dirPhp;
    public string $dirPhpJson;
    public string $dirJson;
    public string $dirPlanilhas;
    public string $dirResultados;
    public string $dirSql;
    public string $dirTxt;
    public string $dirSubpasta;
    public string $nomeClasse;
    public string $dirJsonSubpasta;
    public string $dirJsonSubpastaArquivo;
    public string $dirPlanilhasSubpasta;
    public string $dirPlanilhasSubpastaArquivo;
    public string $dirResultadosSubpasta;
    public string $dirResultadosSubpastaArquivo;
    
    public string $namespaceRaiz;
    public string $namespacePhp;
    public string $namespacePhpJson;
    public string $namespaceJson;
    public string $namespaceResultados;
    public string $namespaceResultadosArquivo;
    
    
    public function definirDiretorios($namespaceArquivo)
    {
        $dirRaiz = str_replace('\vendor\tarcisio\projetos-padroes\src\php\_outros', '', __DIR__) . '\\';
        $dirVendor = $dirRaiz . 'vendor\\';
        $dirSrc = $dirRaiz . 'src\\';
        $dirPhp = $dirSrc . 'php\\';
        $dirPhpJson = $dirPhp . 'json\\';
        $dirJson = $dirSrc . 'json\\';
        $dirResultados = $dirSrc . '_resultados\\';
        $dirSql = $dirSrc . 'sql\\';
        $dirTxt = $dirSrc . 'txt\\';
        $dirPlanilhas = $dirSrc . 'planilhas\\';
        
        $composerArquivo = $dirRaiz . 'composer.json';

        if (file_exists($composerArquivo))
        {
            $json = file_get_contents($composerArquivo);
            $array = json_decode($json, true);
            $namespaceRaiz = substr(array_keys($array['autoload']['psr-4'])[0], 0, -1);
            $namespacePhp = $namespaceRaiz . '\\php';
            $namespacePhpJson = $namespacePhp . '\\json';
            $namespaceJson = $namespaceRaiz . '\\json';
            $namespaceResultados = $namespacePhp . '\\_resultados';
        }
        else
        {
            $namespaceRaiz = "composer não encontrado";
        }
        
        $this->dirRaiz = $dirRaiz;
        $this->dirVendor = $dirVendor;
        $this->dirSrc = $dirSrc;
        $this->dirPhp = $dirPhp;
        $this->dirPhpJson = $dirPhpJson;
        $this->dirJson = $dirJson;
        $this->dirResultados = $dirResultados;
        $this->dirSql = $dirSql;
        $this->dirTxt = $dirTxt;
        $this->dirPlanilhas = $dirPlanilhas;
        $this->namespaceRaiz = $namespaceRaiz;
        $this->namespacePhp = $namespacePhp;
        $this->namespacePhpJson = $namespacePhpJson;
        $this->namespaceJson = $namespaceJson;
        $this->namespaceResultados = $namespaceResultados;
    }

    function definirDiretoriosClasse($namespaceArquivo, $classeArquivo)
    {
        // Classe
        $dirSubpasta = str_replace($this->namespacePhpJson , '', str_replace($this->namespacePhpJson . "\\", '', $namespaceArquivo));
        $dirSubpasta = str_replace($this->namespacePhp , '', str_replace($this->namespacePhp . "\\", '', $dirSubpasta));
        
        $dirSubpasta = str_replace($this->namespacePhpJson, '', str_replace($this->namespacePhpJson . "\\", '', $namespaceArquivo));
        $dirSubpasta = str_replace($this->namespacePhp , '', str_replace($this->namespacePhp . "\\", '', $dirSubpasta));

        if (!empty($dirSubpasta)) {
            $dirSubpasta = $dirSubpasta . '\\';
        }

        $nomeClasse = str_replace($namespaceArquivo . '\\', '', $classeArquivo);

        // Pasta Json
        $dirJsonSubpasta = $this->dirJson . $dirSubpasta;
        $dirJsonSubpastaArquivo = $dirJsonSubpasta . $nomeClasse . '.json';

        // Pasta Resultados
        $dirResultadosSubpasta = str_replace('_resultados\_resultados', '_resultados', $this->dirResultados . $dirSubpasta);
        $dirResultadosSubpastaArquivo = $dirResultadosSubpasta . $nomeClasse . '.json';

        // Pasta Planilhas
        $dirPlanilhasSubpasta = $this->dirPlanilhas . $dirSubpasta;
        $dirPlanilhasSubpastaArquivo = $dirPlanilhasSubpasta . $nomeClasse . '.xlsx';

        $this->dirSubpasta = str_replace('\\\\', '\\', $dirSubpasta);
        $this->nomeClasse = str_replace('\\\\', '\\', $nomeClasse);
        $this->dirJsonSubpasta = str_replace('\\\\', '\\', $dirJsonSubpasta);
        $this->dirJsonSubpastaArquivo = str_replace('\\\\', '\\', $dirJsonSubpastaArquivo);
        $this->dirResultadosSubpasta = str_replace('\\\\', '\\', $dirResultadosSubpasta);
        $this->dirResultadosSubpastaArquivo = str_replace('\\\\', '\\', $dirResultadosSubpastaArquivo);
        $this->dirPlanilhasSubpasta = str_replace('\\\\', '\\', $dirPlanilhasSubpasta);
        $this->dirPlanilhasSubpastaArquivo = str_replace('\\\\', '\\', $dirPlanilhasSubpastaArquivo);
    }
}