<?php

namespace Wikidata\Tests;

use Exception;
use Wikidata\Wikidata;

class WikidataTest extends TestCase
{
    protected Wikidata $wikidata;

    public function setUp(): void
    {
        $this->wikidata = new Wikidata();
    }

    public function testSearchByTerm(): void
    {
        $results = $this->wikidata->search('London');

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

        $result = $results->first();

        $this->assertInstanceOf(\Wikidata\SearchResult::class, $result);

        $this->assertObjectHasProperty('id', $result);
        $this->assertObjectHasProperty('lang', $result);
        $this->assertObjectHasProperty('label', $result);
        $this->assertObjectHasProperty('aliases', $result);
        $this->assertObjectHasProperty('description', $result);
        $this->assertObjectHasProperty('wiki_url', $result);
    }

    public function testSearchOnAnotherLanguage(): void
    {
        $results = $this->wikidata->search('London', 'fr');

        $this->assertEquals('fr', $results->first()->lang);
    }

    public function testSearchWithLimit(): void
    {
        $results = $this->wikidata->search('car', 'en', 10);

        $this->assertEquals(10, $results->count());
    }

    public function testSearchResultsCouldBeEmpty(): void
    {
        $results = $this->wikidata->search('asdfgh');


        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

        $this->assertEquals(true, $results->isEmpty());
    }

    public function testSearchByPropertyIdAndValue(): void
    {
        $results = $this->wikidata->searchBy('P646', '/m/02mjmr');

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

        $result = $results->first();

        $this->assertInstanceOf(\Wikidata\SearchResult::class, $result);

        $this->assertObjectHasProperty('id', $result);
        $this->assertObjectHasProperty('lang', $result);
        $this->assertObjectHasProperty('label', $result);
        $this->assertObjectHasProperty('aliases', $result);
        $this->assertObjectHasProperty('description', $result);
        $this->assertObjectHasProperty('wiki_url', $result);
    }

    public function testSearchByThrowExceptionIfSecondPropertyMissing(): void
    {
        $this->expectException(Exception::class);

        $this->wikidata->searchBy('P646');
    }

    public function testSearchByThrowExceptionIfPropertyIdInvalid(): void
    {
        $this->expectException(Exception::class);

        $this->wikidata->searchBy('Pasd', '/m/02mjmr');
    }

    public function testSearchByPropertyIdAndEntityId(): void
    {
        $results = $this->wikidata->searchBy('P39', 'Q11696');

        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $results);

        $result = $results->first();

        $this->assertInstanceOf(\Wikidata\SearchResult::class, $result);
    }

    public function testGetEntityById(): void
    {
        $entity = $this->wikidata->get('Q44077');

        $this->assertInstanceOf(\Wikidata\Entity::class, $entity);

        $this->assertObjectHasProperty('id', $entity);
        $this->assertObjectHasProperty('lang', $entity);
        $this->assertObjectHasProperty('label', $entity);
        $this->assertObjectHasProperty('aliases', $entity);
        $this->assertObjectHasProperty('description', $entity);
        $this->assertObjectHasProperty('wiki_url', $entity);
    }

    public function testGetEntityOnAnotherLanguage(): void
    {
        $entity = $this->wikidata->get('Q44077', 'es');

        $this->assertEquals('es', $entity->lang);
    }

    public function testGetEntityThrowExceptionIfEntityIdInvalid(): void
    {
        $this->expectException(Exception::class);

        $this->wikidata->get('P1234');
    }
}
