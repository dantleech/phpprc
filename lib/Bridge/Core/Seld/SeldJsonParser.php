<?php

namespace Phpprc\Bridge\Core\Seld;

use Phpprc\Core\Core\Config\JsonParser;
use Seld\JsonLint\JsonParser as RealJsonParser;

class SeldJsonParser implements JsonParser
{
    /**
     * @var JsonParser
     */
    private $seldJsonParser;

    public function __construct(?RealJsonParser $seldJsonParser = null)
    {
        $this->seldJsonParser = $seldJsonParser ?: new RealJsonParser();
    }

    public function parse(string $jsonString): array
    {
        return $this->seldJsonParser->parse($jsonString, RealJsonParser::PARSE_TO_ASSOC);
    }
}
