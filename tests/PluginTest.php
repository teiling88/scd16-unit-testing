<?php

namespace TEiling\Scd16;

class PluginTest extends \PHPUnit_Framework_TestCase
{
    /** @var string $dir */
    protected $dir;

    /**
     * @inheritdoc
     */
    public function __construct($name, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        require_once(__DIR__ . '/../vendor/autoload.php');
        $this->dir = __DIR__;
    }
}
