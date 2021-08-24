<?php

namespace App\Helpers;

class ResponseTime
{
    /**
     * @brief give response time (readable in seconds) for a given $url or error message
     *
     * @param string $url
     * @return bool|string
     */
    public function getResponseTime($url='')
    {
        if (!is_string($url)) return false;
        if (empty($url)) return false;

        try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_exec($ch);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        if($error)
        {
            return (string)$error;
        }
        return 'Took ' . $info['total_time'] . ' seconds to transfer a request to ' . $info['url'];
    }
}