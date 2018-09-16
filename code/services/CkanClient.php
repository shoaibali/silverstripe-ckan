<?php

/**
 * @credits
 * 	- https://github.com/GSA/ckan-php-client/blob/master/src/CKAN/CkanClient.php
 *  - https://github.com/jeffreybarke/Ckan_client-PHP
*/

namespace Ckan;


use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\Exception\ClientException;
use Guzzle\Http\Exception\ClientErrorResponseException;
use Ckan\CkanException;
use Ckan\CkanResponse;
use DateTime;
use DateTimeZone;



class CkanClient extends \RestfulService
{

	/**
	 * @var string
	 */
	private $api_url = '';
	
	/**
	 * @var null|string
	 */
	private $api_key = null;
	
	/**
	 * cURL handler
	 * @var resource
	 */
	private $curl_handler;
	
	/**
	 * cURL headers
	 * @var array
	 */

	private $curl_headers;


	/** @var GuzzleHttp\Client */
	protected $httpClient;


	private static $curl_options = [
		CURLOPT_SSL_VERIFYHOST => false,
	];


	public function __construct($api_url, $api_key = null)
	{
		$this->api_key = $api_key;
		$this->api_url = $api_url;
		$this->initHttpClient($api_url);
	}


/**
	* sendRequest
	* 
	* @param RequestInterface
	*
	* @return Response
	*/
	public function sendRequest(RequestInterface $request)
	{
		try {
			$response = $this->httpClient->send($request);
		} catch (ClientErrorResponseException $e) {
			return new CkanResponse($request, $e->getResponse());
		} catch (ClientException $e) {
			return new CkanResponse($request, $e->getResponse());
		} catch (\Exception $e) {
			throw new CkanException($e->getMessage(), $e->getCode(), $e);
		}
		
		return new CkanResponse($request, $response);	
	}

	/**
	* createRequest
	* 
	* @param string $method
	* @param string $uri
	* @param array $options - Guzzle compatible request options
	*
	* @return RequestInterface
	*/
	private function createRequest($method, $uri, array $options = [], $body = '{}')
	{
		$ret = new Request($method, $uri, $options, is_array($body) ? json_encode($body, JSON_FORCE_OBJECT) : $body);
		if (isset($options['query'])) {
			$uri = $ret->getUri()->withQuery(is_array($options['query']) ? http_build_query($options['query']) : $options['query']);
			return $ret->withUri($uri, true);
		}
		return $ret;
	}

	/**
	* getApiKey
	* 
	* @access  public
	* @return string
	*/
	public function getApiKey()
	{
		return $this->api_key;
	}

	/**
	* getApiUrl
	* 
	* @access  public
	* @return string
	*/
	public function getApiUrl()
	{
		return $this->api_url;
	}

	/**
	* initHttpClient
	*
	* @return void
	*/
	private function initHttpClient()
	{
		$this->httpClient = new HttpClient([ 
			'base_uri' => $this->api_url,
			'headers'  => $this->curl_headers
		]);
	}


    /**
     * Sets the custom cURL headers.
     * @access    private
     * @return    void
     * @since     Version 0.1.0
     */
    private function setHeaders()
    {
        $date = new DateTime(null, new DateTimeZone('UTC'));
        $headers = [
            'Date: ' . $date->format('D, d M Y H:i:s') . ' GMT', // RFC 1123
            'User-Agent'	=> 'shoaibali/silverstripe-ckan',
            'Accept: application/json',
            'Accept-Charset: utf-8',
            'Accept-Encoding: gzip',
            'Cookie: auth_tkt=ckan'
        ];
        if ($this->api_key) {
            $headers[] = 'Authorization: ' . $this->api_key;
        }

        $this->curl_headers = $headers;
    }


	/**
	* getHttpClient
	*
	* @return \GuzzleHttp\Client
	*/
	public function getHttpClient()
	{
		return $this->httpClient;
	}


    /**
     * Return a list of the site’s tags.
     *
     * @param $data
     *
	* @return @see CkanClient::sendRequest
     * @link http://docs.ckan.org/en/latest/api/#ckan.logic.action.get.tag_list
     *  Params:
     *  query (string) – a tag name query to search for, if given only tags whose names contain this string will be
     *     returned (optional) vocabulary_id (string) – the id or name of a vocabulary, if give only tags that belong
     *     to this vocabulary will be returned (optional) all_fields (boolean) – return full tag dictionaries instead
     *     of just names (optional, default: False)
     */
	public function getTags(array $data = [])
	{

		return $this->sendRequest(
            $this->createRequest('GET',
            	'action/tag_list',
            	$data
            )
        );

	}
}