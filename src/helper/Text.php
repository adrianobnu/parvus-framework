<?php
    /**
     * @param $string
     * @param bool $line_breaks
     * @param bool $xml
     * @return string
     */
    function nl2p($string, $line_breaks = true, $xml = true)
    {

        $string = str_replace(array('<p>', '</p>', '<br>', '<br />'), '', $string);

        if ($line_breaks == true)
        {

            return '<p>'.preg_replace(array("/([\n]{2,})/i", "/([^>])\n([^<])/i"), array("</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'), trim($string)).'</p>';

        }
        else
        {

            return '<p>'.preg_replace (
                    array("/([\n]{2,})/i", "/([\r\n]{3,})/i","/([^>])\n([^<])/i"),
                    array("</p>\n<p>", "</p>\n<p>", '$1<br'.($xml == true ? ' /' : '').'>$2'),
                    trim($string)).'</p>';

        }
    }
