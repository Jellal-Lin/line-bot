<?php
if ( ! function_exists('dump')) {
	/**
	 * Outputs the given variables with formatting and location. Huge props
	 * out to Phil Sturgeon for this one (http://philsturgeon.co.uk/blog/2010/09/power-dump-php-applications).
	 * To use, pass in any number of variables as arguments.
	 *
	 * @return void
	 */ 
	function dump() {
		list($callee) = debug_backtrace();
		$arguments = func_get_args();
		$total_arguments = count($arguments);

		echo '<fieldset style="background:#fefefe !important; border:2px red solid; padding:5px">' . PHP_EOL .
			'<legend style="background:lightgrey; padding:5px;">' . $callee['file'] . ' @ line: ' . $callee['line'] . '</legend>' . PHP_EOL .
			'<pre>';

	    $i = 0;
	    foreach ($arguments as $argument) {
			echo '<br/><strong>Debug #' . (++$i) . ' of ' . $total_arguments . '</strong>: ';

			if ( (is_array($argument) || is_object($argument)) && count($argument)) {
				print_r($argument);
			} else {
				var_dump($argument);
			}
		}

		echo '</pre>' . PHP_EOL .
			'</fieldset>' . PHP_EOL;
	}
}


if ( ! function_exists('set_log')) {
	/**
	 * Sets the log.
	 *
	 * @return     array  ( description_of_the_return_value )
	 */
	function set_log($data, $data2 = array()){
		$file_path = './log/';

		$file = fopen($file_path .'log.txt','a');

		fwrite($file, serialize($data) ."\n". serialize($data2)."\n"."===================================\n");

		fclose($file);
	}
}
?>