<?php

namespace App\Helpers;


class ResponseTime
{
    /**
     * @param string $url
     * @return bool|string
     */
    public function getResponseTime($url='')
    {
        if (!is_string($url)) return false;
        if (empty($url)) return false;

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_exec($ch);

        if(!curl_errno($ch))
        {
            $info = curl_getinfo($ch);
            return 'Took ' . $info['total_time'] . ' seconds to transfer a request to ' . $info['url'];
        }
        else
        {
            return (string)curl_error($ch);
        }
        curl_close($ch);
    }
}