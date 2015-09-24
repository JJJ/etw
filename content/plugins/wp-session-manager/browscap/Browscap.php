<?php
/**
 * Browscap.ini parsing class with caching and update capabilities
 *
 * PHP version 5
 *
 * Copyright (c) 2006-2012 Jonathan Stoppani
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included
 * in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
 * OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    Browscap
 * @author     Jonathan Stoppani <jonathan@stoppani.name>
 * @author     Vítor Brandão <noisebleed@noiselabs.org>
 * @author     Mikołaj Misiurewicz <quentin389+phpb@gmail.com>
 * @copyright  Copyright (c) 2006-2012 Jonathan Stoppani
 * @version    1.0
 * @license    http://www.opensource.org/licenses/MIT MIT License
 * @link       https://github.com/GaretJax/phpbrowscap/
 */
class Browscap
{
    /**
     * Current version of the class.
     */
    const VERSION = '2.0.3';

    /**
     * Options for regex patterns.
     *
     * REGEX_DELIMITER: Delimiter of all the regex patterns in the whole class.
     * REGEX_MODIFIERS: Regex modifiers.
     */
    const REGEX_DELIMITER = '@';
    const REGEX_MODIFIERS = 'i';
    const COMPRESSION_PATTERN_START = '@';
    const COMPRESSION_PATTERN_DELIMITER = '|';

    /**
     * The values to quote in the ini file
     */
    const VALUES_TO_QUOTE = 'Browser|Parent';

    /**
     * Flag to enable only lowercase indexes in the result.
     * The cache has to be rebuilt in order to apply this option.
     *
     * @var bool
     */
    public $lowercase = false;

    /**
     * Flag to enable/disable silent error management.
     * In case of an error during the update process the class returns an empty
     * array/object if the update process can't take place and the browscap.ini
     * file does not exist.
     *
     * @var bool
     */
    public $silent = false;

    /**
     * Where to store the cached PHP arrays.
     *
     * @var string
     */
    public $cacheFilename = 'cache.php';

    /**
     * Path to the cache directory
     *
     * @var string
     */
    public $cacheDir = null;

    /**
     * Flag to be set to true after loading the cache
     *
     * @var bool
     */
    protected $_cacheLoaded = false;

    /**
     * Where to store the value of the included PHP cache file
     *
     * @var array
     */
    protected $_userAgents = array();
    protected $_browsers = array();
    protected $_patterns = array();
    protected $_properties = array();

    /**
     * Constructor class, checks for the existence of (and loads) the cache and
     * if needed updated the definitions
     *
     * @param string $cache_dir
     *
     * @throws Exception
     */
    public function __construct($cache_dir)
    {
        if (!isset($cache_dir)) {
            throw new Exception('You have to provide a path to read/store the browscap cache file');
        }

        $old_cache_dir = $cache_dir;
        $cache_dir     = realpath($cache_dir);

        if (false === $cache_dir) {
            throw new Exception(
                sprintf(
                    'The cache path %s is invalid. Are you sure that it exists and that you have permission to access it?',
                    $old_cache_dir
                )
            );
        }

        // Is the cache dir really the directory or is it directly the file?
        if (substr($cache_dir, -4) === '.php') {
            $this->cacheFilename = basename($cache_dir);
            $this->cacheDir      = dirname($cache_dir);
        } else {
            $this->cacheDir = $cache_dir;
        }

        $this->cacheDir .= DIRECTORY_SEPARATOR;
    }

    /**
     * XXX parse
     *
     * Gets the information about the browser by User Agent
     *
     * @param string $user_agent   the user agent string
     * @param bool   $return_array whether return an array or an object
     *
     * @throws Exception
     * @return \stdClass|array  the object containing the browsers details. Array if
     *                    $return_array is set to true.
     */
    public function getBrowser($user_agent = null, $return_array = false)
    {
        // Load the cache at the first request
        if (!$this->_cacheLoaded) {
            $cache_file = $this->cacheDir . $this->cacheFilename;

            $this->_loadCache($cache_file);

        }

        // Automatically detect the useragent
        if (!isset($user_agent)) {
            if (isset($_SERVER['HTTP_USER_AGENT'])) {
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
            } else {
                $user_agent = '';
            }
        }

        $browser = array();
        foreach ($this->_patterns as $pattern => $pattern_data) {
            if (preg_match($pattern . 'i', $user_agent, $matches)) {
                if (1 == count($matches)) {
                    // standard match
                    $key = $pattern_data;

                    $simple_match = true;
                } else {
                    $pattern_data = unserialize($pattern_data);

                    // match with numeric replacements
                    array_shift($matches);

                    $match_string = self::COMPRESSION_PATTERN_START
                        . implode(self::COMPRESSION_PATTERN_DELIMITER, $matches);

                    if (!isset($pattern_data[$match_string])) {
                        // partial match - numbers are not present, but everything else is ok
                        continue;
                    }

                    $key = $pattern_data[$match_string];

                    $simple_match = false;
                }

                $browser = array(
                    $user_agent, // Original useragent
                    trim(strtolower($pattern), self::REGEX_DELIMITER),
                    $this->_pregUnQuote($pattern, $simple_match ? false : $matches)
                );

                $browser = $value = $browser + unserialize($this->_browsers[$key]);

                while (array_key_exists(3, $value)) {
                    $value = unserialize($this->_browsers[$value[3]]);
                    $browser += $value;
                }

                if (!empty($browser[3])) {
                    $browser[3] = $this->_userAgents[$browser[3]];
                }

                break;
            }
        }

        // Add the keys for each property
        $array = array();
        foreach ($browser as $key => $value) {
            if ($value === 'true') {
                $value = true;
            } elseif ($value === 'false') {
                $value = false;
            }

            $tmp_key = $this->_properties[$key];
            if ($this->lowercase) {
                $tmp_key = strtolower($this->_properties[$key]);
            }
            $array[$tmp_key] = $value;
        }

        return $return_array ? $array : (object) $array;
    }

    /**
     * @param string $a
     * @param string $b
     *
     * @return int
     */
    protected function compareBcStrings($a, $b)
    {
        $a_len = strlen($a);
        $b_len = strlen($b);

        if ($a_len > $b_len) {
            return -1;
        }

        if ($a_len < $b_len) {
            return 1;
        }

        $a_len = strlen(str_replace(array('*', '?'), '', $a));
        $b_len = strlen(str_replace(array('*', '?'), '', $b));

        if ($a_len > $b_len) {
            return -1;
        }

        if ($a_len < $b_len) {
            return 1;
        }

        return 0;
    }

    /**
     * That looks complicated...
     *
     * All numbers are taken out into $matches, so we check if any of those numbers are identical
     * in all the $matches and if they are we restore them to the $pattern, removing from the $matches.
     * This gives us patterns with "(\d)" only in places that differ for some matches.
     *
     * @param array  $matches
     * @param string $pattern
     *
     * @return array of $matches
     */
    protected function deduplicateCompressionPattern($matches, &$pattern)
    {
        $tmp_matches = $matches;
        $first_match = array_shift($tmp_matches);
        $differences = array();

        foreach ($tmp_matches as $some_match) {
            $differences += array_diff_assoc($first_match, $some_match);
        }

        $identical = array_diff_key($first_match, $differences);

        $prepared_matches = array();

        foreach ($matches as $i => $some_match) {
            $key = self::COMPRESSION_PATTERN_START
                . implode(self::COMPRESSION_PATTERN_DELIMITER, array_diff_assoc($some_match, $identical));

            $prepared_matches[$key] = $i;
        }

        $pattern_parts = explode('(\d)', $pattern);

        foreach ($identical as $position => $value) {
            $pattern_parts[$position + 1] = $pattern_parts[$position] . $value . $pattern_parts[$position + 1];
            unset($pattern_parts[$position]);
        }

        $pattern = implode('(\d)', $pattern_parts);

        return $prepared_matches;
    }

    /**
     * Converts browscap match patterns into preg match patterns.
     *
     * @param string $user_agent
     *
     * @return string
     */
    protected function _pregQuote($user_agent)
    {
        $pattern = preg_quote($user_agent, self::REGEX_DELIMITER);

        // the \\x replacement is a fix for "Der gro\xdfe BilderSauger 2.00u" user agent match

        return self::REGEX_DELIMITER
            . '^'
            . str_replace(array('\*', '\?', '\\x'), array('.*', '.', '\\\\x'), $pattern)
            . '$'
            . self::REGEX_DELIMITER;
    }

    /**
     * Converts preg match patterns back to browscap match patterns.
     *
     * @param string        $pattern
     * @param array|boolean $matches
     *
     * @return string
     */
    protected function _pregUnQuote($pattern, $matches)
    {
        // list of escaped characters: http://www.php.net/manual/en/function.preg-quote.php
        // to properly unescape '?' which was changed to '.', I replace '\.' (real dot) with '\?', then change '.' to '?' and then '\?' to '.'.
        $search  = array(
            '\\' . self::REGEX_DELIMITER, '\\.', '\\\\', '\\+', '\\[', '\\^', '\\]', '\\$', '\\(', '\\)', '\\{', '\\}',
            '\\=', '\\!', '\\<', '\\>', '\\|', '\\:', '\\-', '.*', '.', '\\?'
        );
        $replace = array(
            self::REGEX_DELIMITER, '\\?', '\\', '+', '[', '^', ']', '$', '(', ')', '{', '}', '=', '!', '<', '>', '|',
            ':', '-', '*', '?', '.'
        );

        $result = substr(str_replace($search, $replace, $pattern), 2, -2);

        if ($matches) {
            foreach ($matches as $one_match) {
                $num_pos = strpos($result, '(\d)');
                $result  = substr_replace($result, $one_match, $num_pos, 4);
            }
        }

        return $result;
    }

    /**
     * Loads the cache into object's properties
     *
     * @param string $cache_file
     *
     * @return boolean
     */
    protected function _loadCache($cache_file)
    {
        require $cache_file;

        $this->_browsers       = $browsers;
        $this->_userAgents     = $userAgents;
        $this->_patterns       = $patterns;
        $this->_properties     = $properties;

        return true;
    }

    /**
     * Converts the given array to the PHP string which represent it.
     * This method optimizes the PHP code and the output differs form the
     * var_export one as the internal PHP function does not strip whitespace or
     * convert strings to numbers.
     *
     * @param array $array the array to parse and convert
     *
     * @return string the array parsed into a PHP string
     */
    protected function _array2string($array)
    {
        $strings = array();

        foreach ($array as $key => $value) {
            if (is_int($key)) {
                $key = '';
            } elseif (ctype_digit((string) $key) || '.0' === substr($key, -2)) {
                $key = intval($key) . '=>';
            } else {
                $key = "'" . str_replace("'", "\'", $key) . "'=>";
            }

            if (is_array($value)) {
                $value = "'" . addcslashes(serialize($value), "'") . "'";
            } elseif (ctype_digit((string) $value)) {
                $value = intval($value);
            } else {
                $value = "'" . str_replace("'", "\'", $value) . "'";
            }

            $strings[] = $key . $value;
        }

        return "array(\n" . implode(",\n", $strings) . "\n)";
    }

}
