<?php

namespace Wikidata\Tests;

use Wikidata\Entity;
use Wikidata\Property;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
  protected $lang = 'en';

  protected $dummy;

  protected $entity;

  public function setUp()
  {
    $this->dummy = [
      'item' => [
        'type' => 'uri',
        'value' => 'http://www.wikidata.org/entity/Q11019'
      ],
      'prop' => [
        'type' => 'uri',
        'value' => 'http://www.wikidata.org/entity/P101'
      ],
      'itemLabel' => [
        'xml:lang' => 'es',
        'type' => 'literal',
        'value' => 'máquina'
      ],
      'itemDescription' => [
        'xml:lang' => 'es',
        'type' => 'literal',
        'value' => 'conjunto de elementos móviles y fijos orientados para realizar un trabajo determinado'
      ],
      'itemAltLabel' => [
        'xml:lang' => 'es',
        'type' => 'literal',
        'value' => 'maquina'
      ],
      'propLabel' => [
        'xml:lang' => 'es',
        'type' => 'literal',
        'value' => 'campo de trabajo'
      ],
      'valueLabel' => [
        'xml:lang' => 'es',
        'type' => 'literal',
        'value' => 'ingeniería'
      ]
    ];

    $this->lang = 'es';

    $this->entity = new Entity([$this->dummy], $this->lang);
  }

  public function testGetEntityId()
  {
    $id = str_replace("http://www.wikidata.org/entity/", "", $this->dummy['item']['value']);

    $this->assertEquals($id, $this->entity->id);
  }

  public function testGetEntityLang()
  {
    $this->assertEquals($this->lang, $this->entity->lang);
  }

  public function testGetEntityLabel()
  {
    $this->assertEquals($this->dummy['itemLabel']['value'], $this->entity->label);
  }

  public function testGetEntityAliases()
  {
    $aliases = explode(', ', $this->dummy['itemAltLabel']['value']);

    $this->assertEquals($aliases, $this->entity->aliases);
  }

  public function testGetEntityDescription()
  {
    $this->assertEquals($this->dummy['itemDescription']['value'], $this->entity->description);
  }

  public function testGetEntityProperties() 
  {
    $property = new Property($this->dummy);
    $properties = collect([ $property->id => $property ]);

    $this->assertEquals($properties, $this->entity->properties);
  }
}