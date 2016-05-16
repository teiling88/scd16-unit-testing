<?php
namespace TEiling\Scd16\Config;

class ArrayConfig implements ConfigInterface
{
    private $imagePath;

    private $csvPath;

    private $groupName;

    private $defaultTaxId;

    /**
     * ArrayConfig constructor.
     *
     * @param $imagePath
     * @param $csvPath
     */
    public function __construct($imagePath, $csvPath)
    {
        $this->imagePath = $imagePath;
        $this->csvPath = $csvPath;
        $this->groupName = 'Größe';
        $this->defaultTaxId = 1;
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @return mixed
     */
    public function getCsvPath()
    {
        return $this->csvPath;
    }

    /**
     * @return mixed
     */
    public function getGroupName()
    {
        return $this->groupName;
    }

    /**
     * @return mixed
     */
    public function getDefaultTaxId()
    {
        return $this->defaultTaxId;
    }
}
