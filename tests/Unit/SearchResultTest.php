<?php

namespace Wikidata\Tests;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Wikidata\SearchResult;

class SearchResultTest extends TestCase
{
  protected $dummy;

  protected $result;

  public function setUp(): void
  {
    $this->dummy = [
      'id' => 'Q1111',
      'lang' => 'en',
      'label' => 'Dummy label',
      'wiki_url' => 'https://en.wikipedia.org/wiki/Dummy',
      'aliases' => ['Dummy alias'],
      'description' => 'Dummy description',
    ];

    $collection = new Collection($this->dummy);

    $this->result = new SearchResult($collection);
  }

  public function testGetResultId(): void
  {
    $this->assertEquals($this->dummy['id'], $this->result->id);
  }

  public function testGetResultLang(): void
  {
    $this->assertEquals($this->dummy['lang'], $this->result->lang);
  }

  public function testGetResultLabel(): void
  {
    $this->assertEquals($this->dummy['label'], $this->result->label);
  }

  public function testGetResultWikiUrl(): void
  {
    $this->assertEquals($this->dummy['wiki_url'], $this->result->wiki_url);
  }

  public function testGetResultAliases(): void
  {
    $this->assertEquals($this->dummy['aliases'], $this->result->aliases);
  }

  public function testGetResultDescription(): void
  {
    $this->assertEquals($this->dummy['description'], $this->result->description);
  }
}
