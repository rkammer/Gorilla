<?php

/**
 * Gorilla Document Manager
 *
 * @author     Gorilla Team
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
require_once ( JPATH_COMPONENT_ADMINISTRATOR . '/libraries/handlers/amazon/aws/aws-autoloader.php' );

// Define namespace from sdk
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

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
	protected $_key_id = null;

	/**
	 * Amazon Secret Key.
	 *
	 *
	 * @var    string
	 */
	protected $_secret_key = null;

	/**
	 * Amazon Bucket.
	 *
	 *
	 * @var    string
	 */
	protected $_bucket = null;

	/**
	 * Cliente of S3 service.
	 *
	 *
	 * @var    S3Client
	 */
	protected $_s3client = null;

	/**
	 * Class constructor which create S3Client.
	 *
	 * @param   boolean $auto_load    True to get S3 identification from config
	 * @param   string  $key_id       Amazon Key ID.
	 * @param   string  $secret_key   Amazon Secret Key.
	 * @param   string  $bucket       Amazon Bucket.
	 *
	 */
	public function __construct($auto_load = true, $key_id = '', $secret_key = '', $bucket = '')
	{
		// Load S3 identification from config
		if ($auto_load) {
			$GorillaConfig = GorillaFactory::getNewConfig();
			$this->_key_id     = $GorillaConfig->getConfigByKey('amazon_key_id')->value;
			$this->_secret_key = $GorillaConfig->getConfigByKey('amazon_secret_key')->value;
			$this->_bucket     = $GorillaConfig->getConfigByKey('amazon_bucket')->value;
		}
		else {
			$this->_key_id     = $key_id;
			$this->_secret_key = $secret_key;
			$this->_bucket     = $bucket;
		}

		// Create S3 client
		$this->_s3client = S3Client::factory(array(
				'key'    => $this->_key_id,
				'secret' => $this->_secret_key
		));

	}

	/**
	 * Upload file.
	 *
	 * @param   string   $guid      Guid to save file.
	 * @param   file     $file      File to upload.
	 *
	 * @return true if success
	 */
	public function upload($guid, $file) {

		// Move attributes
		$this->_guid      = $guid;
		$this->_file      = $file;

		// Upload file
		$this->_s3client->putObject(array(
				'Bucket'     => $this->_bucket,
				'Key'        => $this->_guid,
				'SourceFile' => $this->_file['tmp_name'],
				'ACL'        => 'public-read'
		));

		return true;
	}

	/**
	 * Upload file.
	 *
	 * @param   string   $guid      Guid to save file.
	 * @param   file     $file      File to upload.
	 *
	 * @return true if success
	 */
	public function uploadFromSourceFile($guid, $sourceFile) {

		// Move attributes
		$this->_guid      = $guid;

		// Upload file
		$this->_s3client->putObject(array(
				'Bucket'     => $this->_bucket,
				'Key'        => $this->_guid,
				'SourceFile' => $sourceFile,
				'ACL'        => 'public-read'
		));

		return true;
	}

	/**
	 * Save object from cloud to temp.
	 *
	 * @return true if success, false otherwise.
	 *
	 * @throws S3Exception
	 *
	 */
	private function getFile() {

		try {

			$result = $this->_s3client->getObject(array(
					'Bucket' => $this->_bucket,
					'Key'    => $this->_guid,
					'SaveAs' => $this->getTempFilename()
			));

		} catch (S3Exception $e) {
			$this->setError($e->getMessage());
			return false;
		}

		$this->_file = $this->getTempFilename();

		return true;
	}

	/**
	 * Prepare download the file.
	 *
	 * @param   string   $guid      Guid to obtain file.
	 * @param   string   $filename  File name to rename uploaded file.
	 *
	 * @return	mixed    Exit if successful, false otherwise.
	 *
	 * @throws S3Exception
	 */
	public function download($guid, $filename)
	{
		// Move attributes
		$this->_guid     = $guid;
		$this->_filename = $filename;

		try {

			// Get object from Amazon
			$result = $this->_s3client->getObject(array(
					'Bucket' => $this->_bucket,
					'Key'    => $this->_guid
			));

			header("Content-type: {$result['ContentType']}");
			header("Content-Disposition: attachment; filename=\"{$this->_filename}\"");
			header('Expires: 0');
			header('Cache-Control: must-revalidate');

			// Clean exit buffer
			ob_clean();

			// Push exit buffer to user's browser
			flush();

			// Write file content
			echo $result['Body'];

			// Close exit buffer
			ob_end_flush();

			// Stops php application
			exit();

		} catch (S3Exception $e) {
			$this->setError($e->getMessage());
			return false;
		}

	}

	/**
	 * Create bucket when not exists.
	 *
	 * @return boolean True when OK, False when error.
	 */
	public function createBucket() {

		try {

			if (!$this->_s3client->doesBucketExist($this->_bucket)) {
				$this->_s3client->createBucket(array('Bucket' => $this->_bucket));
				$this->_s3client->waitUntilBucketExists(array('Bucket' => $this->_bucket));
			}

		} catch (Exception $e) {
			$this->setError($e->getMessage());
			return false;
		}

		return true;
	}

}