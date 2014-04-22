<?php

/**
 * Gorilla Document Manager
 *
 * @author     Rodrigo Petters
 * @copyright  2013-2014 SOHO Prospecting LLC (California - USA)
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link https://www.sohoprospecting.com
 *
 * Try not. Do or do not. There is no try.
 */

// No direct access.
defined('_JEXEC') or die;

// Import dependencies
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/handlers/handler.php' );

// Import amazon sdk
require 'aws.phar';

// Define namespace from sdk
use Aws\S3\S3Client;

/**
 * Gorilla handle to manage files in Amazon S3.
 *
 * @package		Joomla.Library
 * @subpackage	lib_gorilla
 */
class GorillaHandlerAmazon extends GorillaHandler
{

	/**
	 * Amazon Key ID.
	 *
	 *
	 * @var    string
	 */
	protected $key_id = null;

	/**
	 * Amazon Secret Key.
	 *
	 *
	 * @var    string
	 */
	protected $secret_key = null;

	/**
	 * Amazon Bucket.
	 *
	 *
	 * @var    string
	 */
	protected $bucket = null;

	/**
	 * Cliente of S3 service.
	 *
	 *
	 * @var    S3Client
	 */
	protected $s3client = null;

	/**
	 * Class constructor which create S3Client.
	 *
	 * @param   mixed    $properties  Either and associative array or another
	 *                                object to set the initial properties of the object.
	 * 			                      - "key_id"     => Amazon Key ID.
	 *                                - "secret_key" => Amazon Secret Key.
	 *                                - "bucket"     => Amazon Bucket.
	 *
	 */
	//public function __construct($key_id, $secret_key, $bucket)
	public function __construct($properties = null)
	{
		if ($properties == null) {

			$GorillaConfig = GorillaFactory::getNewConfig();
			$properties = array(
				'key_id'     => $GorillaConfig->getConfigByKey('amazon_key_id')->value,
				'secret_key' => $GorillaConfig->getConfigByKey('amazon_secret_key')->value,
				'bucket'     => $GorillaConfig->getConfigByKey('amazon_bucket')->value
			);

		}
		parent::__construct($properties);

		// Create S3 client
		$this->s3client = S3Client::factory(array(
				'key'    => $this->key_id,
				'secret' => $this->secret_key
		));

	}

	/**
	 * Upload file.
	 *
	 * @return true if success
	 */
	public function upload()
	{

		// Upload file
		$this->s3client->putObject(array(
				'Bucket'     => $this->bucket,
				'Key'        => $this->_guid,
				'SourceFile' => $this->_file['tmp_name'],
				'ACL'        => 'public-read'
		));

	}

	/**
	 * Prepare file and get link to download.
	 *
	 * @return string Full download link
	 */
	public function getDownloadLink() {

	}

	/**
	 * Create bucket when not exists.
	 *
	 * @return boolean True when OK, False when error.
	 */
	public function createBucket() {

		try {

			if (!$this->s3client->doesBucketExist($this->bucket)) {
				$this->s3client->createBucket(array('Bucket' => $this->bucket));
				$this->s3client->waitUntilBucketExists(array('Bucket' => $this->bucket));
			}

		} catch (Exception $e) {
			$this->setError($e->getMessage());
			return false;
		}

		return true;
	}

}