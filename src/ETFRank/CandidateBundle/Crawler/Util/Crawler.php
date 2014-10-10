<?php

namespace ETFRank\CandidateBundle\Crawler\Util;

use Symfony\Component\DomCrawler\Crawler as BaseCrawler;

/**
 * Adds useful shortcut function to {@link Symfony\Component\DomCrawler\Crawler} class.
 *
 * @author Igor Lukić <igor@byteout.com>
 */
class Crawler extends BaseCrawler
{
    /**
     * Returns the attribute value of the first node of the list, or null when node is empty or attribute doesn't exist.
     *
     * @see Symfony\Component\DomCrawler\Crawler::attr()
     *
     * @param string $attribute The attribute name
     * @param string $trim      Should return value be trimmed
     *
     * @return string|null Required attribute of the first node in the list, or null if the current node list is empty.
     */
    public function attrOrNull($attribute, $trim = true)
    {
        try {
            $result = $this->attr($attribute);
            if ($trim && $result) {
                $result = trim($result);
            }

            return $result;
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Returns the attribute value of the first node of the list, or null if the current node list is empty.
     *
     * @see Symfony\Component\DomCrawler\Crawler::text()
     *
     * @param string $trim  Should return value be trimmed.
     *
     * @return string|null Text of the first node in the list, or null if the current node list is empty.
     */
    public function textOrNull($trim = true)
    {
        try {
            $result = $this->text();
            if ($trim && $result) {
                $result = trim($result);
            }

            return $result;
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Returns the first node of the list as HTML, or null if the current node list is empty.
     *
     * @see Symfony\Component\DomCrawler\Crawler::html()
     *
     * @param string $trim  Should return value be trimmed.
     *
     * @return string|null HTML of the first node in the list, or null if the current node list is empty.
     */
    public function htmlOrNull($trim = true)
    {
        try {
            $result = $this->html();
            if ($trim && $result) {
                $result = trim($result);
            }

            return $result;
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Returns a Link object for the first node in the list, or null if the current node list is empty.
     *
     * @see Symfony\Component\DomCrawler\Crawler::link()
     *
     * @param string $xpath XPatch expression.
     *
     * @return string|null Link object of the first node in the list, or null if the current node list is empty.
     */
    public function linkOrNull($method = 'get')
    {
        try {
            return $this->link($method);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Returns a Form object for the first node in the list or null if the current node list is empty.
     *
     * @see Symfony\Component\DomCrawler\Crawler::form()
     *
     * @param array  $values An array of values for the form fields
     * @param string $method The method for the form
     *
     * @return string|null Form object for the first node in the list or null if the current node list is empty.
     */
    public function formOrNull(array $values = null, $method = null)
    {
        try {
            return $this->form($values, $method);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Checks if current node list is empty.
     *
     * @return boolean If node list is empty true is returned, false otherwise.
     */
    public function isEmpty()
    {
        return !count($this);
    }

    /**
     * Returns current uri
     *
     * @return string Current uri
     */
    public function getUri()
    {
        return $this->uri;
    }
}
