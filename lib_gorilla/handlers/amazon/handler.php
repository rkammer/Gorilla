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
	public function upload() {
		echo "Uploaded=" . $this->_file['name'];
		echo "GUID=" . $this->_guid;

		echo '1<br/>';



		echo '2<br/>';

		//cria o objecto
		$s3Client = S3Client::factory(array(
				'key'    => '',
				'secret' => '',
		));

		echo '3<br/>';

		//nome do bucket
		$bucket_name = 'rkammer';

		echo '4<br/>';

		//cria o bucket (na primeira vez)
		//$s3Client->createBucket(array('Bucket' => $bucket_name));

		echo '5<br/>';

		//cria um arquivo txt com o conteudo "Hello World"
		//$result = $s3Client->putObject(array(
		//		'Bucket' => $bucket_name,
		//		'Key'    => 'data.txt',
		//		'Body'   => 'Hello World!!'
		//));

		$s3Client->putObject(array(
				'Bucket'     => $bucket_name,
				'Key'        => $this->_guid,
				'SourceFile' => $this->_file['tmp_name'],
				'ACL'        => 'public-read'
		));

		echo "banana";

	}

	/**
	 * Prepare file and get link to download.
	 *
	 * @return string Full download link
	 */
	public function getDownloadLink() {

	}

}