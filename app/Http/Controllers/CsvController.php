<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Support\Facades\Storage;

class CsvController extends Controller
{


  
    
          public function baixarCsv()
        {
            $urlPagina = "https://rh.pontagrossa.pr.gov.br/estatisticas/download/servidores";
            
            // Requisição para acessar a página
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36'
            ])->get($urlPagina);
    
            if ($response->successful()) {
                // Carrega o conteúdo HTML da página com o Crawler
                $crawler = new Crawler($response->body());
    
                // Procurar o primeiro link que leva ao arquivo CSV
                $link = $crawler->filter('a[href]')
                                ->reduce(function (Crawler $node) {
                                    return strpos($node->text(), 'Servidores') !== false;
                                })
                                ->first();
    
                if (!$link->count()) {
                    // Caso não tenha encontrado o link exato, buscar por "Servidores-"
                    $link = $crawler->filter('a[href*="Servidores-"]')->first();
                }
    
                if ($link->count()) {
                    $urlDoArquivo = $link->attr('href');
    
                    // Corrige o link se for relativo
                    if (strpos($urlDoArquivo, 'http') === false) {
                        $urlDoArquivo = "https://rh.pontagrossa.pr.gov.br" . $urlDoArquivo;
                    }
    
                    // Baixar o arquivo CSV
                    $csvResponse = Http::get($urlDoArquivo);
    
                    if ($csvResponse->successful()) {
                        // Nome do arquivo com data atual
                        $nomeArquivo = "servidores_" . date("Y-m-d") . ".csv";
    
                        // Salva o arquivo na pasta storage/app/public
                        Storage::disk('local')->put("public/$nomeArquivo", $csvResponse->body());
    
                        // Adiciona uma mensagem flash para indicar que o download foi realizado
                        session()->flash('success', 'Download do CSV concluído com sucesso!');
                    } else {
                        // Caso haja algum erro no download
                        session()->flash('error', 'Houve um erro ao tentar baixar o arquivo.');
                    }
                } else {
                    // Caso o link não seja encontrado
                    session()->flash('error', 'Arquivo CSV não encontrado.');
                }
            } else {
                // Caso a requisição para a página de servidores falhe
                session()->flash('error', 'Erro ao acessar a página. Não foi possível buscar o arquivo.');
            }
    
            // Redireciona de volta à página anterior ou para qualquer página de sua escolha
            return redirect()->route('painel');
        }
    }
    




