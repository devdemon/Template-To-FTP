<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Plugin Info
 *
 * @var array
 */
$plugin_info = array(
	'pi_name' => 'Template To FTP',
	'pi_version' => '2.0.0',
	'pi_author' => '<a href="http://www.devdemon.com/">DevDemon</a>',
	'pi_author_url' => 'http://www.devdemon.com/',
	'pi_description' => 'Sends Plugin Tagdata to an FTP as a file.',
	'pi_usage' => 'http://www.devdemon.com'
);

class Template2ftp {

	/**
	 * The return data
	 *
	 * @var string
	 **/
	public $return_data = '';

	/**
	 * Constructor
	 *
	 * Loops over embedded template variables and creates a class string
	 * Sets return data that is then outputted to template
	 **/
	public function __construct()
	{
		$this->EE =& get_instance();

	}


}

/* End of file pi.template2ftp.php */
/* Location: ./system/expressionengine/third_party/template2ftp/pi.template2ftp.php */