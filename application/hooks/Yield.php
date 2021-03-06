<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Yields
{
    function doYield()
    {
        global $OUT;
        $CI =& get_instance();
        $output = $CI->output->get_output();
        $CI->yield = isset($CI->yield) ? $CI->yield : TRUE;
        $CI->layout = isset($CI->layout) ? $CI->layout : 'default';
        if ($CI->yield === TRUE)
        {
            if (!preg_match('/(.+).php$/', $CI->layout))
            {
                $CI->layout .= '.php';
            }
            $requested = APPPATH . 'views/layouts/' . $CI->layout;
            $layout = $CI->load->file($requested, true);
            $view = str_replace("{yield}", $output, $layout);

			if (!preg_match('/(.+).php$/', $CI->left))
			{
				$CI->left .= '.php';				
			}

			$requested_left = APPPATH. 'views/layouts/' . $CI->left;
			$left = $CI->load->file( $requested_left, true );
			$view = str_replace( '{left}', $left, $view );
        }
        else
        {
            $view = $output;
        }
        $OUT->_display($view);
		
    }
}
?>
