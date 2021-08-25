<?php

namespace App\Helpers;

class ResponseTime
{
    /**
     * @brief give response time (human readable in seconds) for a given $url or error message
     *
     * @param string $url
     * @return bool|string
     */
    public function getResponseTime($url='')
    {
        if (!is_string($url)) return false;
        if (empty($url)) return false;

        try
        {
            // using curl to try to retrieve the url page
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_exec($ch);
        }
        catch (\Exception $e)
        {
            // for any exception, return the message of the exception
            return $e->getMessage();
        }
        $info = curl_getinfo($ch);
        $error = curl_error($ch);
        if($error)
        {
            // if was an error (like url not exists) return the received error
            return (string)$error;
        }
        // return in human readable the response time in seconds
        return 'Took ' . $info['total_time'] . ' seconds to transfer a request to ' . $info['url'];
    }
}
