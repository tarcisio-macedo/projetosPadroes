<?php

namespace Tarcisio\ProjetosPadroes\php\_outros;

class diretorios
{
    public string $namespace;
    public string $namespacePhp;
    public string $namespacePhpJson;
    public string $namespaceJson;
    public string $namespaceResultados;
    public string $namespaceResultadosArquivo;

    public string $dirRaiz;
    public string $dirVendor;
    public string $dirSrc;
    public string $dirPhp;
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
    
    
    public function definirDiretorios()
    {
        $namespaceArquivo = __NAMESPACE__;
        $namespace = str_replace('\php\_outros', '', $namespaceArquivo);
        $namespacePhp = $namespace . '\\php';
        $namespacePhpJson = $namespacePhp . '\\json';
        $namespaceJson = $namespace . '\\json';
        $namespaceResultados = $namespacePhp . '\\_resultados';

        $dirRaiz = substr(__DIR__, 0, strpos(__DIR__, '\src')) . '\\';
        $dirVendor = $dirRaiz . 'vendor\\';
        $dirSrc = $dirRaiz . 'src\\';
        $dirPhp = $dirSrc . 'php\\';
        $dirJson = $dirSrc . 'json\\';
        $dirResultados = $dirSrc . '_resultados\\';
        $dirSql = $dirSrc . 'sql\\';
        $dirTxt = $dirSrc . 'txt\\';
        $dirPlanilhas = $dirSrc . 'planilhas\\';
        

        $this->namespace = $namespace;
        $this->namespacePhp = $namespacePhp;
        $this->namespacePhpJson = $namespacePhpJson;
        $this->namespaceJson = $namespaceJson;
        $this->namespaceResultados = $namespaceResultados;
        $this->dirRaiz = $dirRaiz;
        $this->dirVendor = $dirVendor;
        $this->dirSrc = $dirSrc;
        $this->dirPhp = $dirPhp;
        $this->dirJson = $dirJson;
        $this->dirResultados = $dirResultados;
        $this->dirSql = $dirSql;
        $this->dirTxt = $dirTxt;
        $this->dirPlanilhas = $dirPlanilhas;
    }

    function definirDiretoriosClasse($namespace, $classe)
    {
        // Classe
        $dirSubpasta = str_replace($this->namespacePhpJson , '', str_replace($this->namespacePhpJson . "\\", '', $namespace));
        $dirSubpasta = str_replace($this->namespacePhp , '', str_replace($this->namespacePhp . "\\", '', $dirSubpasta));

        if (!empty($dirSubpasta)) {
            $dirSubpasta = $dirSubpasta . '\\';
        }

        $nomeClasse = str_replace($namespace . '\\', '', $classe);

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