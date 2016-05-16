<?php

namespace TEiling\Scd16\Utils;

class ArticleUtil
{
    /**
     * @param $price
     *
     * @return float
     */
    public static function convertPrice($price)
    {
        $fmt = numfmt_create('de_DE', \NumberFormatter::DECIMAL);

        return numfmt_parse($fmt, $price);
    }

    /**
     * @param $string
     *
     * @return array
     */
    public static function getKeyValueArray($string)
    {
        $chunks = array_chunk(preg_split('/(=|,)/', $string), 2);

        return array_combine(array_column($chunks, 0), array_column($chunks, 1));
    }

    /**
     * @param string $orderNumber
     *
     * @return string
     */
    public static function convertOrderNumber($orderNumber)
    {
        return str_replace(['½', '/'], ['.5', '-'], $orderNumber);
    }


    /**
     * @param string $orderNumber
     * @param mixed $stock
     *
     * @return bool|string
     */
    public static function getMainOrderNumber($orderNumber, $stock)
    {
        $stockArray = self::getKeyValueArray($stock);
        foreach ($stockArray as $key => $value) {
            if ($value > 0 && $key !== '-') {
                return self::convertOrderNumber($orderNumber . '-' . $key);
            } elseif ($key === '-') {
                return $orderNumber;
            }
        }

        return false;
    }
}
