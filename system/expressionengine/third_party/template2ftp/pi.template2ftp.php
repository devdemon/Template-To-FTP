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
	public function Template2ftp()
	{
		$this->EE =& get_instance();

		$config = array();
		$config['hostname'] = $this->EE->TMPL->fetch_param('hostname');
		$config['username'] = $this->EE->TMPL->fetch_param('username');
		$config['password'] = $this->EE->TMPL->fetch_param('password');
		$config['path']		= $this->EE->TMPL->fetch_param('path');
		$config['filename']	= $this->EE->TMPL->fetch_param('filename');
		$config['permissions']	= '0' . $this->EE->TMPL->fetch_param('permissions', '775');
		$config['mode']	= $this->EE->TMPL->fetch_param('mode', 'auto');
		$config['passive_mode'] = ($this->EE->TMPL->fetch_param('passive_mode') == 'no') ? FALSE : TRUE;
		$config['debug'] = ($this->EE->TMPL->fetch_param('debug') == 'yes') ? TRUE : FALSE;

		$temp_dir = APPPATH.'cache/template2ftp/';

		// Does the destination folder already exist?
		if (@is_dir($temp_dir) == FALSE)
		{
			// Lets rename sthe temp_folder
			@mkdir($temp_dir);
		}

		if ($file = @fopen($temp_dir.$config['filename'], 'wb'))
		{
			$content = $this->EE->TMPL->tagdata;
			flock($file, LOCK_EX);
			fwrite($file, $content);
			flock($file, LOCK_UN);
			fclose($file);
		}
		else
		{
			return;
		}

		// Load Library
		$this->EE->load->library('ftp');

		// Connect!
		$this->EE->ftp->connect($config);

		// Upload
		$this->EE->ftp->upload($temp_dir.$config['filename'], $config['path'].$config['filename'], $config['mode'], $config['permissions']);

		// Kill
		$this->EE->ftp->close();

		@unlink($temp_dir.$config['filename']);
	}

	// ********************************************************************************* //

}

/* End of file pi.template2ftp.php */
/* Location: ./system/expressionengine/third_party/template2ftp/pi.template2ftp.php */