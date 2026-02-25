<?php

/**
 * @package Cache - A simple file based cache (based from Erik Giberti's FileCache class. http://af-design.com/blog/2010/07/30/simple-file-based-caching-in-php/)
 * @link http://www.lodev09.com
 * @author Jovanni Lo
 * @copyright 2014 Jovanni Lo, all rights reserved
 * @license
 * The MIT License (MIT)
 * Copyright (c) 2014 Jovanni Lo
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * Class to implement a file based cache. This is useful for caching large objects such as
 * API/Curl responses or HTML results that aren't well suited to storing in small memory caches
 * or are infrequently accessed but are still expensive to generate.
 *
 * For security reasons, it's *strongly* recommended you set your cache directory to be outside
 * of your web root and on a drive independent of your operating system.
 *
 * Uses JSON, PHP native serialization and encryption/decryption
 *
 * Sample usage:
 *
 * $cache = new Cache('/var/www/cache/');
 * $data = $cache->get('sampledata');
 * if(!$data){
 *   $data = array('a'=>1,'b'=>2,'c'=>3);
 *   $cache->set('sampledata', $data, 3600);
 * }
 * print $data['a'];
 *
 */

namespace Common;

class Cache {

    /**
     * Value is pre-pended to the cache, should be the full path to the directory
     * @var string
     */
    protected $root = '/tmp';

    /**
     * For holding any error messages that may have been raised
     * @var string
     */
    protected $error = null;

    /**
     * The encryption key. This is private! set this inside this class
     * @var string
     */
    private static $_key = "Fil3C@ch33ncryptionK3y";

    /**
     * @param string $root The root of the file cache.
     */
    function __construct($root = '/tmp') {
        $this->root = $root;
        // Requires the native JSON library
        if (!function_exists('json_decode') || !function_exists('json_encode')) {
            throw new Exception('Cache needs the JSON PHP extensions.');
        }
    }

    public static function setKey($key) {
        self::$_key = $key;
    }

    /**
     * Saves data to the cache. Anything that evaluates to false, null, '', boolean false, 0 will
     * not be saved.
     * @param string $key An identifier for the data
     * @param mixed $data The data to save
     * @param int $ttl Seconds to store the data
     * @returns boolean True if the save was successful, false if it failed
     */
    public function set($key, $data = false, $ttl = 18000) {
        if (!$key) {
            $this->error = "Invalid key";
            return false;
        }
        if (!$data) {
            $this->error = "Invalid data";
            return false;
        }

        $cache_file = $this->_getKeyFile($key);
        $store = [
            'data' => serialize($data),
            'ttl' => time() + $ttl,
        ];
        $status = false;
        try {
            $fh = fopen($cache_file, "w+");
            if (flock($fh, LOCK_EX)) {
                ftruncate($fh, 0);
                fwrite($fh, $this->_encrypt(json_encode($store)));
                flock($fh, LOCK_UN);
                $status = true;
            }
            fclose($fh);
            chmod($cache_file, 0775);
        }
        catch (exception $e) {
            $this->error = "Exception caught: ".$e->getMessage();
            return false;
        }
        return $status;
    }

    /**
     * Reads the data from the cache
     * @param string $key An identifier for the data
     * @returns mixed Data that was stored
     */
    public function get($key) {
        if (!$key) {
            $this->error = "Invalid key";
            return false;
        }

        $cache_file = $this->_getKeyFile($key);
        $file_content = null;

        if (file_exists($cache_file) !== true) {
            return false;
        }

        // Get the data from the file
        try {
            $fh = fopen($cache_file, "r");
            if (flock($fh, LOCK_SH)) {
                $file_content = trim($this->_decrypt(fread($fh, filesize($cache_file))));
            }
            fclose($fh);
        }
        catch (exception $e) {
            $this->error = "Exception caught: ".$e->getMessage();
            return false;
        }

        // Assuming we got something back...
        if ($file_content) {
            $store = json_decode($file_content, true);
            if ($store['ttl'] < time()) {
                unlink($cache_file); // remove the file
                $this->error = "Data expired";
                return false;
            } else return unserialize($store['data']);
        } else return false;
    }

    /**
     * Remove a key, regardless of it's expire time
     * @param string $key An identifier for the data
     */
    public function delete($key) {
        if (!$key) {
            $this->error = "Invalid key";
            return false;
        }

        $cache_file = $this->_getKeyFile($key);

        try {
            unlink($cache_file); // remove the file
        }
        catch (exception $e) {
            $this->error = "Exception caught: ".$e->getMessage();
            return false;
        }

        return true;
    }

    /**
     * check if cache file exists
     * @param  string $key An identifier for the data
     * @return boolean true if it does otherwise false
     */
    public function exists($key) {
        return file_exists($this->_getKeyFile($key));
    }

    /**
     * returns the filename of the cache data
     * @param  string $key An identifier for the data
     * @return string      the filename
     */
    public function getFilename($key) {
        return $this->_getKeyFile($key);
    }

    /**
     * Reads and clears the internal error
     * @returns string Text of the error raised by the last process
     */
    public function getError() {
        $message = $this->error;
        $this->error = null;
        return $message;
    }

    /**
     * Can be used to inspect internal error
     * @returns boolean True if we have an error, false if we don't
     */
    public function hasError() {
        return ($this->error !== null) ? true : false;
    }

    /**
     * returns an encrypted string
     * @param  string $pure_string source string to encrypt
     * @return string                   decrypted string
     */
    private function _encrypt($data) {
        $key = self::$_key;
        $iv = hash_hmac('sha256', $this->root, $key);
        return Util::encrypt($data, $key, $iv);
    }

    /**
     * returns a decrypted string
     * @param  string $encrypted_string ecrypted string
     * @return string                   decrypted string
     */
    private function _decrypt($data) {
        $key = self::$_key;
        $iv = hash_hmac('sha256', $this->root, $key);
        return Util::decrypt($data, $key, $iv);
    }

    /**
     * Create a key for the cache
     * @todo Beef up the cleansing of the file.
     * @param string $key The key to create
     * @returns string The full path and filename to access
     */
    private function _getKeyFile($key) {
        $safe_key = str_replace(array(
            '.',
            '/',
            ':',
            '\''), array(
            '_',
            '-',
            '-',
            '-'), trim($key));
        return $this->root.'/'.$safe_key.".cache";
    }
}
?>