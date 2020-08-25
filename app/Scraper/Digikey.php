<?php
namespace App\Scraper;

use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class Digikey
{

    public function scrape($url)
    {
        // $url = 'https://www.digikey.com/product-detail/en/cypress-semiconductor-corp/S25FL064LABNFI043/428-4075-1-ND/7318405';

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

       // dump(array_merge($overview,$attributes));
        // save to DB
        // $products = new Product;
        // $products->attributes = json_encode($product);
        // $products->save();
        // dump($product);
        return array_merge($overview,$attributes);
    }
    public function searchByTag($tag = null)
    {
        $url = 'https://www.digikey.com/products/en?keywords=SN097-073-03-A';
        $client = new Client();
        $crawler = $client->request('GET', $url);
        
        if ($crawler->filter('table#productTable')->count()) {
            $links = $crawler->filter('td.tr-mfgPartNumber a')->each(
                function (Crawler $node, $i) {
                    return $node->link()->getUri();
                }
            );
            foreach ($links as $link) {
                dump($this->scrape($link));
            }
        }
        if ($crawler->filter('table#product-attribute-table')->count()) 
        {
            dump($this->scrape($url));
        }   
        return 0;
    }
}
