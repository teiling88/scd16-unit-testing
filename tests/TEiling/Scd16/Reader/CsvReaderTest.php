<?php

namespace TEiling\Scd16\Csv;

use TEiling\Scd16\PluginTest;
use TEiling\Scd16\Reader\CsvReader;

class CsvReaderTest extends PluginTest
{
    /**
     * @group unit-tests
     * @covers TEiling\Scd16\Reader\CsvReader::readCsv()
     */
    public function testReadCsv()
    {
        /** @var CsvReader $reader */
        $reader = new CsvReader();
        $csvData = $reader->readCsv($this->dir . '/fixtures/shopexport_short.csv');
        $firstRow = $csvData[0];

        static::assertArrayHasKey('Artikelnummer', $firstRow);
        static::assertArrayHasKey('Preis', $firstRow);
        static::assertArrayHasKey('VKS', $firstRow);
        static::assertArrayHasKey('WG_NUM_1', $firstRow);
        static::assertArrayHasKey('WG_NUM_2', $firstRow);
        static::assertArrayHasKey('WG_NUM_3', $firstRow);
        static::assertArrayHasKey('WG_TXT_1', $firstRow);
        static::assertArrayHasKey('WG_TXT_2', $firstRow);
        static::assertArrayHasKey('WG_TXT_3', $firstRow);
        static::assertArrayHasKey('Modell', $firstRow);
        static::assertArrayHasKey('UVP', $firstRow);
        static::assertArrayHasKey('Bild', $firstRow);
        static::assertArrayHasKey('Hersteller', $firstRow);
        static::assertArrayHasKey('Farbbezeichnung', $firstRow);
        static::assertArrayHasKey('Pseudoverkauf', $firstRow);
        static::assertArrayHasKey('PseudoPreis', $firstRow);
        static::assertArrayHasKey('Farbe', $firstRow);
        static::assertArrayHasKey('Obermaterial', $firstRow);
        static::assertArrayHasKey('Innenfutter', $firstRow);
        static::assertArrayHasKey('Sohle', $firstRow);
        static::assertArrayHasKey('Weite', $firstRow);
        static::assertArrayHasKey('Absatz', $firstRow);
        static::assertArrayHasKey('Fußbett', $firstRow);
        static::assertArrayHasKey('Schaftweite', $firstRow);
        static::assertArrayHasKey('Bildupdate', $firstRow);
        static::assertArrayHasKey('Abverkauf', $firstRow);
        static::assertArrayHasKey('Inhalt', $firstRow);
        static::assertArrayHasKey('Information', $firstRow);
        static::assertArrayHasKey('Eigenschaften', $firstRow);
        static::assertArrayHasKey('Material', $firstRow);
        static::assertArrayHasKey('Fabrikartikel', $firstRow);
        static::assertArrayHasKey('Bemerkung', $firstRow);
        static::assertArrayHasKey('Bestand', $firstRow);
        static::assertArrayHasKey('EAN', $firstRow);
        static::assertArrayHasKey('Notiz', $firstRow);
    }
}
