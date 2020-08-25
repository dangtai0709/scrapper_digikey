<?php
namespace App\Scraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Digikey
{

    public function scrape($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $attributes = $crawler->filter('table#product-attribute-table tr th')->each(
            function (Crawler $node, $i) {
                return [$node->text() => $node->nextAll()->text()];
            }
        );
        $attributes = array_merge(...$attributes);
        $categories = $crawler->filter('table#product-attribute-table tr td.attributes-td-categories-link')->each(
            function (Crawler $node, $i) {
                return $node->text();
            }
        );
        $attributes['Categories'] = join(" , ", $categories);
        // product-overview
        $overview = $crawler->filter('table#product-overview tr th')->each(
            function (Crawler $node, $i) {
                return [$node->text() => $node->nextAll()->text()];
            }
        );
        $overview = array_merge(...$overview);
        return array_merge($overview,$attributes);
    }
    public function searchByTag($tag = null)
    {
        $url = 'https://www.digikey.com/products/en?keywords='.$tag;
        // $url = 'https://www.digikey.com/products/en?keywords=SN097-073-03-A';
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $data = [];
        if ($crawler->filter('table#product-attribute-table')->count()) 
        {
            $data[]= $this->scrape($url);
        }
        if ($crawler->filter('table#productTable')->count()) {
            $links = $crawler->filter('td.tr-mfgPartNumber a')->each(
                function (Crawler $node, $i) {
                    return $node->link()->getUri();
                }
            );
            foreach ($links as $link) {
                $data[]= $this->scrape($link);
            }
        }
        return $data;
    }
}
