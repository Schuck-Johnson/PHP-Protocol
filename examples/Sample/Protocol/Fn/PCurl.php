<?php

namespace Sample\Protocol\Fn;

class PCurl extends \Clj\AProtocolInstance implements \Clj\Protocol\IFn
{
    protected static $_curl_options;
    
    protected $lookup_ref;

    public function __construct($lookup_ref)
    {
        $this->lookup_ref = $lookup_ref;
    }
    /**
     * Gets the list of curl option name and constant values
     * @return array
     */
    protected function get_curl_options()
    {
        if (isset(self::$_curl_options))
        {
            return self::$_curl_options;
        }

        $curl_extension = new \ReflectionExtension('cURL');
        self::$_curl_options = array_fill_keys($curl_extension->getConstants(), true);
        return self::$_curl_options;
    }

    public function fn($context, array $parameters = array())
    {
        $url = $this->lookup_ref->getRef()->get($context, 'url');
        $return_error = (bool) $this->lookup_ref->getRef()->get($parameters, 'return_error', false);
        return $this->make_request($url, $parameters, $return_error);
    }

    /**
     * Makes a curl request and sends back a curl response object
     * @param string $url: The url we are making the curl request to
     * @param array $options: Curl option
     * @param bool $return_error: If the error code and message if any should be returned
     * @return \Sample\ErrorResponse
     */
    protected function make_request($url, $options, $return_error)
    {
        $clean_options = array_intersect_key($options, self::get_curl_options());
        $curl_handler = curl_init($url);
        curl_setopt_array($curl_handler, $clean_options);

        $curl_error = '';
        $curl_error_number = 0;
        $curl_response = false;
        try
        {
            $curl_response = curl_exec($curl_handler);

            $curl_error = curl_error($curl_handler);
            $curl_error_number = curl_errno($curl_handler);
        }
        catch (\Exception $e)
        {
            $curl_error = $e->getMessage();
            $curl_error_number = 9999;
        }

        curl_close($curl_handler);

        if ($return_error)
        {
            return new \Sample\ErrorResponse($curl_response, $curl_error_number, $curl_error);
        }
        return $curl_response;
    }
}
