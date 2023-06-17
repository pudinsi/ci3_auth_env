<?php  if ( ! defined('__NAJZMI_PUDINTEA__')) exit('No direct script access allowed');

function minify()
	{
		ini_set("pcre.recursion_limit", "16777");
		$CI =& get_instance();
		$s1= $CI->uri->segment(1);
		$s2= $CI->uri->segment(2);
		$buffer = $CI->output->get_output();

		if ($s1=='admin'){
			
			$CI->output->set_output($buffer);

		}else{

			$buffer = preg_replace('~<!--(?!<!)[^\[>].*?-->~s','',$buffer);

			if ($s1=='blog'&&!empty ($s2)){

				'';
				$script = '|script';

			}else{
				$buffer = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\')\/\/.*))/','',$buffer);
				$script = '';
			}

			$re = '%# Collapse whitespace everywhere but in blacklisted elements.
			(?>             # Match all whitespans other than single space.
			  [^\S ]\s*     # Either one [\t\r\n\f\v] and zero or more ws,
			| \s{2,}        # or two or more consecutive-any-whitespace.
			) # Note: The remaining regex consumes no text at all...
			(?=             # Ensure we are not in a blacklist tag.
			  [^<]*+        # Either zero or more non-"<" {normal*}
			  (?:           # Begin {(special normal*)*} construct
				<           # or a < starting a non-blacklist tag.
				(?!/?(?:textarea|pre|ins|blockquote'.$script.')\b)
				[^<]*+      # more non-"<" {normal*}
			  )*+           # Finish "unrolling-the-loop"
			  (?:           # Begin alternation group.
				<           # Either a blacklist start tag.
				(?>textarea|pre|ins|blockquote'.$script.')\b
			  | \z          # or end of file.
			  )             # End alternation group.
			)  # If we made it here, we are not in a blacklist tag.
			%Six';

			$new_buffer = preg_replace($re, " ", $buffer);

			
			if ($new_buffer === null)
			{
					$new_buffer = $buffer;
			}

			$CI->output->set_output($new_buffer);
		}

		$CI->output->_display();
	}

/* End of file minify.php */
/* Location: ./application/hooks/minify.php */
/* Pudin S. I . https://t.me/pudin_ira */
?>