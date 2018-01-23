<?php
namespace YarnResourceManager;

class Request
{
    const FORMAT_DEFAULT = 'default';
    const FORMAT_JSON = 'json';
    const FORMAT_XML = 'xml';

    const GET = 'GET';
    const PUT = 'PUT';

    /**
     * Format default response (php array).
     *
     * @param  string $response resource manager api response
     * @return mixed  formatted response
     */
    final private function formatDefault($response)
    {
        return json_decode($response, TRUE);
    }

    /**
     * Format JSON response.
     *
     * @param  string $response resource manager api response
     * @return string  formatted response
     */
    final private function formatJson($response)
    {
        return json_encode(json_decode($response, TRUE), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Format XML response.
     *
     * @param  string $response resource manager api response
     * @return string  formatted response
     */
    final private function formatXml($response)
    {
        $domxml = new \DomDocument('1.0');
        $domxml->preserveWhiteSpace = FALSE;
        $domxml->formatOutput = TRUE;
        $domxml->loadXML($response);
        return $domxml->saveXML();
    }

    /**
     * Format response.
     *
     * @param  string $response resource manager api response
     * @return mixed  formatted response
     */
    final private function formatResponse($response)
    {
        switch ($this->format)
        {
            case 'default': return $this->formatDefault($response);
            case 'json':    return $this->formatJson($response);
            case 'xml':     return $this->formatXml($response);
        }
    }

    /**
     * Returns json array from CURL response.
     *
     * @param  string $url        api url
     * @param  array  $parameters supported api parameters
     * @param  string $request    type of request, defaults is 'GET'
     * @return mixed  either request response or http response code on error
     */
    final public function request($url, array $parameters = [], $request = self::GET)
    {
        $content_type = ($this->format == 'default' || $this->format == 'json')
            ? 'Accept: application/json'
            : 'Accept: application/xml';

        $url = !empty($parameters) ? $url . '?' . http_build_query($parameters) : $url;

        $curlopts = [
            CURLOPT_URL            => $url,
            CURLOPT_HEADER         => FALSE,
            CURLOPT_HTTPHEADER     => [$content_type],
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_FOLLOWLOCATION => TRUE,
            CURLOPT_CUSTOMREQUEST  => $request,
        ];

        $curl_handle = curl_init();
        curl_setopt_array($curl_handle, $curlopts);
        $response = curl_exec($curl_handle);
        $http_status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

        return ($http_status == 200) ? $this->formatResponse($response) : $http_status;
    }
}
