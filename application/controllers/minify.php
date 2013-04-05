<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
Copyright (C) 2011 by Ryan Tallmadge

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.


NOTE:

Make sure the base_url is set in your config file /application/config/config.php

Also, update the permissions for your /application/cache directory to be writtable



*/

	/**
	 * Class Minify - Used to control the interaction with minifying JS and CSS code
	 */

class Minify extends CI_Controller {
	
	//Public vars
	public $minifyjs;//Hold the minified JS
	public $minifycss;//Hold the minified CSS
	
	//Private vars
	private $_js_directory = FCPATH.'/js/'; //Holds the directory for housing your JS, update to where you are holding the JS
	private $_css_directory = FCPATH.'/css/'; //Holds the directory for housing your CSS, update to where you are holding the CSS
	
	/**
	 * Start the class, load the jsmin library for use in the methods below
	 */
    function __construct()
	{
		parent::__construct();
		$this->load->library('jsmin');
	}
    
   	/**
	 * Redirect a user if they come to the index by mistake
	 */
	public function index()
	{
		redirect('/');
	}
	
	/**
	 * Minify mutliple JS files into one file and deliver back to the requesting user
	 */
	public function js()
	{
        //Get the files to be minified
		$scripts = explode("|",urldecode($this->uri->segment(3)));
		//Loop through the files getting thier content
        foreach($scripts as $file) {
            //Check if the file exists
			if(!is_file($this->_js_directory . $file)) continue;
    		//Minify the content of the file, add it to the out put string
            $this->minifyjs .= $this->jsmin->minify(file_get_contents($this->_js_directory . $file));
		}
        //Open our gzip handeler
		ob_start ("ob_gzhandler");
        //Tell the client we are feeding it javascript... YUM!
		header("Content-type: text/javascript");
        //Shove out the JS
		echo trim($this->minifyjs);
        //Dont run anything else, dont want to cause a header issue
		exit;
	}
	
	/**
	 * Minify mutliple CSS files into one file and deliver back to the requesting user
	 */
	public function css()
	{
        //Get the css to be minified
		$scripts = explode("|",urldecode($this->uri->segment(3)));
        //Loop through the files and get thier content
		foreach($scripts as $file) {
            //Check if the fill exists
			if(!is_file($this->_css_directory .$file)) continue;
            //Minify the css and add it to the out string
    		$this->minifycss .= $this->cssmin(file_get_contents($this->_css_directory . $file));
		}
        //Load the gzip handeler
		ob_start ("ob_gzhandler");
		//Tell the client we have css ready to go
        header("Content-type: text/css");
        //Shove out the CSS to the client
		echo trim($this->minifycss);
		exit;
	}

    //Private method to minify the css
	private function cssmin($css){
		$css = preg_replace( '#\s+#', ' ', $css );
		$css = preg_replace( '#/\*.*?\*/#s', '', $css );
		$css = str_replace( '; ', ';', $css );
		$css = str_replace( ': ', ':', $css );
		$css = str_replace( ' {', '{', $css );
		$css = str_replace( '{ ', '{', $css );
		$css = str_replace( ', ', ',', $css );
		$css = str_replace( '} ', '}', $css );
		$css = str_replace( ';}', '}', $css );
		$css = str_replace( '../images', $this->config->item('base_url').'images', $css );	
		return trim( $css );
	}

}

/* End of file Minify.php */
/* Location: ./application/controllers/Minify.php */
