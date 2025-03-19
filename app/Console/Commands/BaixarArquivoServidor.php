<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class BaixarArquivoServidor extends Command
{
    protected $signature = 'baixar:servidor';
    protected $description = 'Baixa o arquivo CSV de servidores do site da prefeitura de Ponta Grossa';

    public function handle()
    {
        // URL da página onde o link do arquivo está
        $urlPagina = "https://rh.pontagrossa.pr.gov.br/estatisticas/download/servidores";

        // Criar uma instância do cliente HTTP
        $client = new Client();
        $resposta = $client->get($urlPagina);

        if ($resposta->getStatusCode() == 200) {
            // Usando o DomCrawler para parsear o HTML
            $crawler = new Crawler($resposta->getBody()->getContents());

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

                $this->info("Link encontrado: $urlDoArquivo");

                // Função para baixar o arquivo
                $this->baixarArquivo($urlDoArquivo, 'Servidores.csv');
            } else {
                $this->error('Nenhum link para o arquivo encontrado.');
            }
        } else {
            $this->error('Erro ao acessar a página. Código: ' . $resposta->getStatusCode());
        }
    }

    private function baixarArquivo($url, $nomeArquivo)
    {
        $client = new Client();
        $resposta = $client->get($url, ['stream' => true]);

        if ($resposta->getStatusCode() == 200) {
            $conteudo = fopen($nomeArquivo, 'w');
            while (!$resposta->getBody()->eof()) {
                fwrite($conteudo, $resposta->getBody()->read(1024));
            }
            fclose($conteudo);

            $this->info("Download concluído: $nomeArquivo");
        } else {
            $this->error("Erro ao baixar o arquivo. Código: " . $resposta->getStatusCode());
        }
    }
}
