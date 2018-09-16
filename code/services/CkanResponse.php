<?php


namespace Ckan;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
* CkanResponse
**/
class CkanResponse
{

	/** @var RequestInterface */
	protected $request;

	/** @var RequestInterface */
	protected $response;

	/** @var array|false */
	protected $data;


	/**
	 * HTTP status codes.
	 * @var        array
	 */
	private $http_status_codes = [
	    '100' => 'Continue',
	    '200' => 'OK',
	    '301' => 'Moved Permanently',
	    '400' => 'Bad Request',
	    '401' => 'Unauthorized',
	    '403' => 'Not Authorized',
	    '404' => 'Not Found',
	    '409' => 'Conflict (e.g. name already exists)',
	    '411' => 'Length required',
	    '500' => 'Service Error',
	    '503' => 'Service unavailable (e.g. CKAN build in progress, or you are banned)'
	];


	public function __construct(RequestInterface $request, ResponseInterface $response)
	{
		$this->request  = $request;
		$this->response = $response;
		if ($this->getResponseObject()->hasHeader('content-type')) {
			if (preg_match('/application\/json/i', $this->getResponseObject()->getHeader('content-type')[0])) {
				$this->data = json_decode($this->getResponseObject()->getBody(), true);
			} else {
				$this->data = false;
			}
		}
	}

	/**
	* getRequestObject
	*
	* @return RequestInterface
	*/
	public function getRequestObject()
	{
		return $this->response;
	}

	/**
	* getResponseObject
	*
	* @return ResponseInterface
	*/
	public function getResponseObject()
	{
		return $this->response;
	}

	/**
	* getData
	*
	* @return mixed
	*/
	public function getData()
	{
		return $this->data;
	}

	/**
	* isSuccess
	*
	* @return bool
	*/
	public function isSuccess()
	{
		$data = $this->getData();

		if (!$data) {
			return false;
		}

		if (isset($data['error'])) {
			return false;
		}

		return true;
	}

	/**
	* isError
	*
	* @return bool
	*/
	public function isError()
	{
		return !$this->isSuccess();
	}

	/**
	* getError
	*
	* @return array
	*/
	public function getError()
	{
		if ($this->isSuccess()) {
			return null;
		}

		return $this->data['error'];
	}
}