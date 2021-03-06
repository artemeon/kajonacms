<?php

namespace Kajona\System\System;

/**
 * Util class for processing strings.
 *
 * Class StringUtil
 * @package Kajona\System\System
 * @author stefan.meyer1@yahoo.de
 * @since 4.6
 */
class StringUtil
{
    /**
     * Returns the index within the haystack of the first occurrence of the specified needle.
     * Returns false if the value is not found.
     *
     * @param $strHaystack
     * @param $strNeedle
     * @param $bitCaseSensitive
     * @return bool|int
     */
    public static function indexOf($strHaystack, $strNeedle, $bitCaseSensitive = true)
    {
        if (_mbstringloaded_) {
            if ($bitCaseSensitive) {
                return mb_strpos($strHaystack, $strNeedle);
            }
            return mb_stripos($strHaystack, $strNeedle);
        } else {
            if ($bitCaseSensitive) {
                return strpos($strHaystack, $strNeedle);
            }
            return stripos($strHaystack, $strNeedle);
        }
    }


    /**
     * Returns the index within the haystack of the last occurrence of the specified needle.
     * Returns false if the needle is not found.
     *
     * @param $strHaystack
     * @param $strNeedle
     * @param $bitCaseSensitive
     * @return bool|int
     */
    public static function lastIndexOf($strHaystack, $strNeedle, $bitCaseSensitive = true)
    {
        if (_mbstringloaded_) {
            if ($bitCaseSensitive) {
                return mb_strrpos($strHaystack, $strNeedle);
            }
            return mb_strripos($strHaystack, $strNeedle);
        } else {
            if ($bitCaseSensitive) {
                return strrpos($strHaystack, $strNeedle);
            }
            return strripos($strHaystack, $strNeedle);
        }
    }

    /**
     * Returns whether two string are equals
     *
     * @param string $strLeft
     * @param string $strRight
     * @return int
     */
    public static function equals($strLeft, $strRight)
    {
        return strcasecmp($strLeft, $strRight) === 0;
    }

    /**
     * Returns the length of this string.
     *
     * @param $strString
     * @return int
     */
    public static function length($strString)
    {
        if (_mbstringloaded_) {
            return mb_strlen($strString);
        } else {
            return strlen($strString);
        }
    }

    /**
     * Converts all of the characters in the given String to lower case using the rules of the default locale.
     *
     * @param $strString
     * @return string
     */
    public static function toLowerCase($strString)
    {
        if (_mbstringloaded_) {
            return mb_strtolower($strString);
        } else {
            return strtolower($strString);
        }
    }

    /**
     * Converts all of the characters in the given String to upper case using the rules of the default locale.
     *
     * @param $strString
     * @return string
     */
    public static function toUpperCase($strString)
    {
        if (_mbstringloaded_) {
            return mb_strtoupper($strString);
        } else {
            return strtoupper($strString);
        }
    }

    /**
     * Returns a new string that is a substring of the given string.
     *
     * @param $strString
     * @param $intBeginIndex
     * @param null $intLength
     * @return string
     */
    public static function substring($strString, $intBeginIndex, $intLength = null)
    {
        if (_mbstringloaded_) {
            if ($intLength === null) {
                return mb_substr($strString, $intBeginIndex);
            } else {
                return mb_substr($strString, $intBeginIndex, $intLength);
            }
        } else {
            if ($intLength === null) {
                return substr($strString, $intBeginIndex);
            } else {
                return substr($strString, $intBeginIndex, $intLength);
            }
        }
    }

    /**
     * Trim whitespaces (or other characters) from the beginning and end of a string.
     *
     * @param $strString
     * @return string
     */
    public static function trim($strString)
    {
        return trim($strString);
    }

    /**
     * Truncates the string to a given length.
     * If $strAdd is provided, the given string $strAdd will be added to the end of the string
     *
     * @param $strString
     * @param $intLength
     * @param string $strAdd
     * @return string
     */
    public static function truncate($strString, $intLength, $strAdd = "…")
    {
        if ($intLength > 0 && self::length($strString) > $intLength) {
            return trim(self::substring($strString, 0, $intLength)).$strAdd;
        } else {
            return $strString;
        }
    }

    /**
     * Replaces each substring of the $strSubject that matches the given regular expression $mixedSearch
     * with the given replacement $mixedReplace.
     *
     * @param $mixedSearch
     * @param $mixedReplace
     * @param $strSubject
     * @param bool $bitUnicodesafe
     * @param bool $bitCaseSensitive
     *
     * @return mixed
     */
    public static function replace($mixedSearch, $mixedReplace, $strSubject, $bitUnicodesafe = false, $bitCaseSensitive = true)
    {
        if ($bitUnicodesafe) {
            if (!is_array($mixedSearch)) {
                $mixedSearch = '!'.preg_quote($mixedSearch, '!').'!u'.($bitCaseSensitive ? '' : 'i');
            } else {
                foreach ($mixedSearch as $strKey => $strValue) {
                    $mixedSearch[$strKey] = '!'.preg_quote($strValue).'!u'.($bitCaseSensitive ? '' : 'i');
                }
            }
            return preg_replace($mixedSearch, $mixedReplace, $strSubject);
        } else {
            return $bitCaseSensitive ? str_replace($mixedSearch, $mixedReplace, $strSubject) : str_ireplace($mixedSearch, $mixedReplace, $strSubject);
        }
    }


    /**
     * Converts a string to an int
     *
     * @param $strString
     * @return int|null
     */
    public static function toInt($strString)
    {
        if (is_numeric($strString)) {
            return intval($strString);
        }

        return null;
    }

    /**
     * Converts a string to a float
     *
     * @param $strString
     * @return float|null
     */
    public static function toFloat($strString)
    {
        if (is_numeric($strString)) {
            return floatval($strString);
        }

        return null;
    }

    /**
     * Converts a string to an array.
     *
     * If $strString is null, array(null) will be returned.
     * If delimiter is not set and $string is not an array, array($string) will be returned.
     *
     * @param $strString
     * @param string $strDelimiter
     *
     * @return array
     */
    public static function toArray($strString, $strDelimiter = ",")
    {
        if (is_array($strString)) {
            return $strString;
        } elseif (is_string($strString) && $strString !== "" && !empty($strDelimiter)) {
            return explode($strDelimiter, $strString);
        }

        return null;
    }

    /**
     * Converts a string to a Date
     *
     * @param $strString
     * @return Date|null
     */
    public static function toDate($strString)
    {
        if ($strString instanceof Date) {
            return $strString;
        } elseif ($strString == "") {
            return null;
        } else {
            return new Date($strString);
        }
    }


    /**
     * Checks if a string starts with the given search string $strSearch.
     *
     * @param $strString
     * @param $strSearch
     * @return bool
     */
    public static function startsWith($strString, $strSearch)
    {
        $intLengthSearch = self::length($strSearch);
        $strStart = self::substring($strString, 0, $intLengthSearch);

        return $strStart === $strSearch;
    }


    /**
     * Checks if a string ends with the given search string $strSearch.
     *
     * @param $strString
     * @param $strSearch
     * @return bool
     */
    public static function endsWith($strString, $strSearch)
    {
        $intLengthSearch = self::length($strSearch);
        $strStart = self::substring($strString, $intLengthSearch * -1);

        return $strStart === $strSearch;
    }


    /**
     * Perform a global regular expression match on a given string.
     *
     * @param $strString
     * @param $strPattern
     * @return int| FALSE on error or if no matches are found
     */
    public static function matches($strString, $strPattern)
    {
        if (_mbstringloaded_) {
            return mb_ereg($strPattern, $strString);
        } else {
            return preg_match("/".$strPattern."/", $strString);
        }
    }

    /**
     * Encodes a string so it can be used in a html attribute as javascript string
     *
     * @param string $strString
     * @return string
     */
    public static function jsSafeString($strString)
    {
        $strJson = json_encode((string)$strString, JSON_UNESCAPED_UNICODE);
        $strJson = trim($strJson, '"');
        $strJson = addcslashes($strJson, "'");

        return htmlspecialchars($strJson, ENT_QUOTES | ENT_HTML401);
    }

    /**
     * Builds an associative array out of an (urlencoded) param string
     *
     * We dont use the parse_str on the complete string directly since the method checks the max_input_vars ini and we
     * easily reach this limit. Because of this we split up the string into specific chunks and then use the parse_str
     * method
     *
     * @param $strParams
     * @return array
     */
    public static function parseUrlString($strParams)
    {
        $arrParams = [];

        /*
        parse_str($strParams, $arrTemp);
        return $arrTemp;
        */

        $arrParts = explode("&", $strParams);

        $grouped = [];
        $scalar = [];

        foreach ($arrParts as $strOneVal) {
            $arr = [];
            parse_str($strOneVal, $arr);

            $key = key($arr);
            $value = current($arr);

            if (is_array($value)) {
                if (!isset($grouped[$key])) {
                    $grouped[$key] = [];
                }
                $grouped[$key][] = $strOneVal;
            } else {
                $scalar[] = $strOneVal;
            }
        }

        foreach ($grouped as $items) {
            $arr = [];
            parse_str(implode("&", $items), $arr);

            $arrParams = array_merge_recursive($arrParams, $arr);
        }

        foreach ($scalar as $item) {
            $arr = [];
            parse_str($item, $arr);

            $arrParams = array_merge($arrParams, $arr);
        }

        return $arrParams;
    }
}
