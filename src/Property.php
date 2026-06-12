<?php

namespace Wikidata;

use Illuminate\Support\Collection;
use Wikidata\Value;

class Property
{
    /**
     * @var string Property Id
     */
    public $id;

    /**
     * @var string Property label
     */
    public $label;

    /**
     * @var \Illuminate\Support\Collection Collection of property values
     */
    public $values;

    /**
     * @param array|Collection $data
     */
    public function __construct($data)
    {
        $this->parseData($data);
    }

    /**
     * Parse input data
     *
     * @param array|Collection $data
     */
    private function parseData($data): void
    {
        $grouped = collect($data)->groupBy('statement');
        $flatten = $grouped->flatten(1);

        $this->id = get_id($flatten[0]['prop']);
        $this->label = $flatten[0]['propertyLabel'];
        $this->values = $grouped->values()->map(fn($v): \Wikidata\Value => new Value($v->toArray()));
    }
}
