<?php
/**
 * @package Make
 */


interface MAKE_Style_ManagerInterface extends MAKE_Util_ModulesInterface {
	public function get_styles_as_inline();

	public function get_file_url();
}