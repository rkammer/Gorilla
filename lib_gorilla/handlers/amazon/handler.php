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
jimport('gorilla.handlers.handler');

// Import amazon sdk
require 'aws.phar';
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
	 * Upload file.
	 *
	 * @return true if success
	 */
	public function upload()
	{
		//$GorillaConfig = GorillaFactory::getNewConfig();

		//$GorillaConfig = new GorillaModelConfig();

		$db 	= JFactory::getDBO ();

		$query	= $db->getQuery(true);
		$query->select($db->quoteName('value'));
		$query->from('#__gorilla_config');
		$query->where($db->quoteName('key') . ' = ' . $db->quote('AMAZON_KEY_ID'));
		$db->setQuery($query);
		$row = $db->loadObject();

		$amazon_key_id = $row->value;

		$query	= $db->getQuery(true);
		$query->select($db->quoteName('value'));
		$query->from('#__gorilla_config');
		$query->where($db->quoteName('key') . ' = ' . $db->quote('AMAZON_SECRET_KEY'));
		$db->setQuery($query);
		$row = $db->loadObject();

		$amazon_secret_key = $row->value;

		$query	= $db->getQuery(true);
		$query->select($db->quoteName('value'));
		$query->from('#__gorilla_config');
		$query->where($db->quoteName('key') . ' = ' . $db->quote('AMAZON_BUCKET'));
		$db->setQuery($query);
		$row = $db->loadObject();

		$amazon_bucket = $row->value;

		// Create S3 client
		$s3Client = S3Client::factory(array(
				'key'    => $amazon_key_id,
				'secret' => $amazon_secret_key,
		));

		// Create bucket
		$bucket_name = $amazon_bucket;
		//$s3Client->createBucket(array('Bucket' => $bucket_name));
		//$s3Client->waitUntilBucketExists(array('Bucket' => $bucket_name));

		// Upload file
		$s3Client->putObject(array(
				'Bucket'     => $bucket_name,
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

}