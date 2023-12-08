<?php
/**
	* Get and use the File Upload field URL 
	*
	* @link https://wpforms.com/developers/how-to-get-the-url-from-the-file-upload-form-field/
	*/ 
function wpf_dev_frontend_confirmation_message( $message, $form_data, $fields, $entry_id ) {     
		// Only run on my form with ID = 1389
		if ( absint( $form_data[ 'id' ] ) !== 1389 ) {
			return $message;
		}
		//get the information where is the php file executed
		//$dir = __FILE__;
		//echo($dir);
		// Grab the URL of the single image uploaded to the form
		$myfileurl_1 = $fields[ '1' ][ 'value' ];
		$myfileurl_2 = $fields[ '2' ][ 'value' ];
		$myfileurl_3 = $fields[ '3' ][ 'value' ];
		$filepath = '/var/www/html'.substr(dirname($myfileurl_1),20).'/';
		$myfile_1 = $filepath . basename($myfileurl_1);
		$myfile_2 = $filepath . basename($myfileurl_2);
		$myfile_3 = $filepath . basename($myfileurl_3);
		$suffixid=substr($myfile_1, -10, 5);
		//echo ($suffixid);
		$target_url = 'http://168.138.32.47/wp-content/uploads/wpforms/1389-f05f25a6e830b9397e1298b968153a6d/target_file_'.$suffixid.'.xlsx';
		$target_file = '/var/www/html/wp-content/uploads/wpforms/1389-f05f25a6e830b9397e1298b968153a6d/target_file_'.$suffixid.'.xlsx';
		$py_file = '/var/www/html/wp-content/uploads/wpforms/1389-f05f25a6e830b9397e1298b968153a6d/calculation.py';
		$cmd = 'python3'.' '.$py_file.' '.$myfile_1.' '.$myfile_2.' '.$myfile_3.' '.$target_file;
		//exec is the built in function of php which can be used call python execution and return the output and exit status code
		$retval=null;
		$output=null;
		exec($cmd, $output, $retval);
		//get the exit code of python execution
		//echo ($retval);
		//get the python cmd for debug
		//echo ($cmd);
		//get the output which is arry so need print_r() function, instead of echo
		print_r ($output);
		if ($retval != 0) {
			return '<p>' . 'calculation failed!' . '</p>';
		}     
		//Echo out the image under the confirmation message
		//$image .= '<div class="image_container"><img src="' . $myfileurl . '" class="small"></div>';
		$target_link = '<a href="' . $target_url . '">View</a>';
		$fileslist .= '<p>' . $myfileurl_1 . '</p>';
		$fileslist .= '<p>' . $myfileurl_2 . '</p>';
		$fileslist .= '<p>' . $myfileurl_3 . '</p>';
		$message = '<p>' . esc_html__( 'Thank you for your submission. Below is the result you uploaded for our target calculation.', 'plugin-domain' ) . '</p>';
		return $message . '<p>' . $target_link . '</p>';
		//return $message . '<p>' . $image . '</p>';
		//return $message . '<p>' . $fileslist . '</p>';
}
add_filter( 'wpforms_frontend_confirmation_message', 'wpf_dev_frontend_confirmation_message', 10, 4 );