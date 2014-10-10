<?php

namespace ETFRank\CandidateBundle\Crawler\Util;

/**
 * Utility for easy extracting string parts using regular expressions.
 *
 * @author Igor Lukić <igor@byteout.com>
 */
class RegExParser
{
    /**
     * Performs regular expression search and returns found results.
     *
     * Results are formatted as suggested by $resultPattern argument. Result pattern complies to the same rules as
     * replacement pattern in {@link preg_replace()} function (use $n or ${n} wildcards to insert appropriate match).
     *
     * You can search for one instance and retrieve it as a string (by default, when $matchAll is false), or you can
     * retrieve array of results if you set $matchAll to true (then preg_match_all() function will be used instead of
     * preg_match() function which is used by default).
     *
     * @param string  $text          Text for searching.
     * @param string  $searchPattern Regular expression to search for.
     * @param string  $resultPattern String describing format of the result. It uses $n or ${n} wildcards to insert
     *                               matched values.
     * @param mixed   $default       Default value to return if no match is found.
     * @param integer $matchAll      If true {@link preg_match_all()} function will be used for search.
     *
     * @return string|array|mixed Matched string (or array of strings) formatted using $resultPattern, or $default value
     *                            if it is not found.
     */
    public function search($text, $searchPattern, $resultPattern = '$0', $default = null, $matchAll = false)
    {
        if ($text === null) {
            return $default;
        }

        $matches = array();

        if ($matchAll) {
            $match = preg_match_all($searchPattern, $text, $matches, PREG_SET_ORDER);
        } else {
            $match = preg_match($searchPattern, $text, $matches);
            $matches = array($matches);
        }

        if ($match) {
            $resultPattern = preg_split('/(\\\\\$|\$\d+|\${\d+})/', $resultPattern, null, PREG_SPLIT_DELIM_CAPTURE);
            $resultArray = array();
            foreach ($matches as $match) {
                //building result map
                $map = array('\\$' => '$');
                foreach ($match as $key => $m) {
                    //keys
                    $map['$' . $key] = $m;
                    $map['${' . $key . '}'] = $m;
                }

                //preparing result
                $result = array();
                foreach ($resultPattern as $r) {
                    //if pattern part is replace pattern we are looking for replacement in the map
                    if (preg_match('/^(\\\\\$|\$\d+|\${\d+})$/', $r)) {
                        if (isset($map[$r])) {
                            $result[] = $map[$r];
                        } else {
                            $result[] = '';
                        }
                    } else {
                        $result[] = $r;
                    }
                }
                $result = implode('', $result);

                $resultArray[] = $result;
            }

            if ($matchAll) {
                return $resultArray;
            } else {
                return $resultArray[0];
            }
        } else {
            return $default;
        }
    }

    /**
     * Performs regular expression search and returns found results as array of strings.
     *
     * @see search()
     *
     * @param string  $text          Text for searching.
     * @param string  $searchPattern Regular expression to search for.
     * @param string  $resultPattern String describing format of the result. It uses $n or ${n} wildcards to insert
     *                               matched values.
     * @param mixed   $default       Default value to return if no match is found.
     *
     * @return string|array|mixed Matched string (or array of strings) formatted using $resultPattern, or $default value
     *                            if it is not found.
     */
    public function searchAll($text, $searchPattern, $resultPattern = '$0', $default = null)
    {
        return $this->search($text, $searchPattern, $resultPattern, $default, true);
    }
}
