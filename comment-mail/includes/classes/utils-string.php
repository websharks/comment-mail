<?php
/**
 * String Utilities
 *
 * @since 141111 First documented version.
 * @copyright WebSharks, Inc. <http://www.websharks-inc.com>
 * @license GNU General Public License, version 3
 */
namespace comment_mail // Root namespace.
{
	if(!defined('WPINC')) // MUST have WordPress.
		exit('Do NOT access this file directly: '.basename(__FILE__));

	if(!class_exists('\\'.__NAMESPACE__.'\\utils_string'))
	{
		/**
		 * String Utilities
		 *
		 * @since 141111 First documented version.
		 */
		class utils_string extends abs_base
		{
			/**
			 * Class constructor.
			 *
			 * @since 141111 First documented version.
			 */
			public function __construct()
			{
				parent::__construct();
			}

			/**
			 * Strips slashes.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string See {@link strip_deep()}.
			 *
			 * @return string See {@link strip_deep()}.
			 */
			public function strip($string)
			{
				return $this->strip_deep((string)$string);
			}

			/**
			 * Strips slashes in strings deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed $values Anything can be converted into a stripped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object Stripped string, array, object.
			 */
			public function strip_deep($values)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->strip_deep($_values);
					unset($_key, $_values); // Housekeeping.

					return $values; // Stripped deeply.
				}
				$string = (string)$values;

				return stripslashes($string);
			}

			/**
			 * Trims string.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string See {@link trim_deep()}.
			 * @param string $chars See {@link trim_deep()}.
			 * @param string $extra_chars See {@link trim_deep()}.
			 *
			 * @return string See {@link trim_deep()}.
			 */
			public function trim($string, $chars = '', $extra_chars = '')
			{
				return $this->trim_deep((string)$string, $chars, $extra_chars);
			}

			/**
			 * Trims strings deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed  $values Any value can be converted into a trimmed string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string $chars Specific chars to trim.
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass.
			 *
			 * @param string $extra_chars Additional chars to trim.
			 *
			 * @return string|array|object Trimmed string, array, object.
			 */
			public function trim_deep($values, $chars = '', $extra_chars = '')
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->trim_deep($_values, $chars, $extra_chars);
					unset($_key, $_values); // Housekeeping.

					return $values; // Trimmed deeply.
				}
				$string      = (string)$values;
				$chars       = (string)$chars;
				$extra_chars = (string)$extra_chars;

				$chars = isset($chars[0]) ? $chars : " \r\n\t\0\x0B";
				$chars = $chars.$extra_chars; // Concatenate.

				return trim($string, $chars);
			}

			/**
			 * Trims/strips string.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string See {@link trim_strip_deep()}.
			 * @param string $chars See {@link trim_strip_deep()}.
			 * @param string $extra_chars See {@link trim_strip_deep()}.
			 *
			 * @return string See {@link trim_strip_deep()}.
			 */
			public function trim_strip($string, $chars = '', $extra_chars = '')
			{
				return $this->trim_strip_deep((string)$string, $chars, $extra_chars);
			}

			/**
			 * Trims and strips slashes in strings deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed  $values Any value can be converted into a trimmed/stripped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string $chars Specific chars to trim.
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass.
			 *
			 * @param string $extra_chars Additional chars to trim.
			 *
			 * @return string|array|object Trimmed/stripped string, array, object.
			 */
			public function trim_strip_deep($values, $chars = '', $extra_chars = '')
			{
				return $this->trim_deep($this->strip_deep($values), $chars, $extra_chars);
			}

			/**
			 * Trims HTML markup.
			 *
			 * @param string $string A string value.
			 *
			 * @param string $chars Other specific chars to trim (HTML whitespace is always trimmed).
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
			 *
			 * @param string $extra_chars Additional specific chars to trim.
			 *
			 * @return string Trimmed string (HTML whitespace is always trimmed).
			 */
			public function trim_html($string, $chars = '', $extra_chars = '')
			{
				return $this->trim_html_deep($string, $chars, $extra_chars);
			}

			/**
			 * Trims HTML markup deeply.
			 *
			 * @param mixed  $values Any value can be converted into a trimmed string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param string $chars Other specific chars to trim (HTML whitespace is always trimmed).
			 *    Defaults to PHP's trim: " \r\n\t\0\x0B". Use an empty string to bypass this argument and specify additional chars only.
			 *
			 * @param string $extra_chars Additional specific chars to trim.
			 *
			 * @return string|array|object Trimmed string, array, object (HTML whitespace is always trimmed).
			 */
			public function trim_html_deep($values, $chars = '', $extra_chars = '')
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->trim_html_deep($_values, $chars, $extra_chars);
					unset($_key, $_values); // Housekeeping.

					return $this->trim_deep($values, $chars, $extra_chars);
				}
				$string = (string)$values;

				if(is_null($whitespace = &$this->static_key(__FUNCTION__, 'whitespace')))
					$whitespace = implode('|', array_keys($this->html_whitespace));

				$string = preg_replace('/^(?:'.$whitespace.')+|(?:'.$whitespace.')+$/i', '', $string);

				return $this->trim($string, $chars, $extra_chars);
			}

			/**
			 * Escape single quotes.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $string See {@link esc_sq_deep()}.
			 * @param integer $times See {@link esc_sq_deep()}.
			 *
			 * @return string See {@link esc_sq_deep()}.
			 */
			public function esc_sq($string, $times = 1)
			{
				return $this->esc_sq_deep((string)$string, $times);
			}

			/**
			 * Escapes single quotes deeply.
			 *
			 * @param mixed   $values Any value can be converted into an escaped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string|array|object Escaped string, array, object.
			 */
			public function esc_sq_deep($values, $times = 1)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->esc_sq_deep($_values, $times);
					unset($_key, $_values); // Housekeeping.

					return $values; // All done.
				}
				$string = (string)$values;
				$times  = abs((integer)$times);

				return str_replace("'", str_repeat('\\', $times)."'", $string);
			}

			/**
			 * Escapes JS line breaks (removes "\r"); and escapes single quotes.
			 *
			 * @param string  $string A string value.
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string Escaped string, ready for JavaScript.
			 */
			public function esc_js_sq($string, $times = 1)
			{
				return $this->esc_js_sq_deep((string)$string, $times);
			}

			/**
			 * Escapes JS; and escapes single quotes deeply.
			 *
			 * @note This follows {@link http://www.json.org JSON} standards, with TWO exceptions.
			 *    1. Special handling for line breaks: `\r\n` and `\r` are converted to `\n`.
			 *    2. This does NOT escape double quotes; only single quotes.
			 *
			 * @param mixed   $value Any value can be converted into an escaped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string|array|object Escaped string, array, object (ready for JavaScript).
			 */
			public function esc_js_sq_deep($value, $times = 1)
			{
				if(is_array($value) || is_object($value))
				{
					foreach($value as $_key => &$_value)
						$_value = $this->esc_js_sq_deep($_value, $times);
					unset($_key, $_value); // Housekeeping.

					return $value; // All done.
				}
				$value = str_replace(array("\r\n", "\r", '"'), array("\n", "\n", '%%!dq!%%'), (string)$value);
				$value = str_replace(array('%%!dq!%%', "'"), array('"', "\\'"), trim(json_encode($value), '"'));

				return str_replace('\\', str_repeat('\\', abs((integer)$times) - 1).'\\', $value);
			}

			/**
			 * Escape double quotes.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $string See {@link esc_dq_deep()}.
			 * @param integer $times See {@link esc_dq_deep()}.
			 *
			 * @return string See {@link esc_dq_deep()}.
			 */
			public function esc_dq($string, $times = 1)
			{
				return $this->esc_dq_deep((string)$string, $times);
			}

			/**
			 * Escapes double quotes deeply.
			 *
			 * @param mixed   $values Any value can be converted into an escaped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string|array|object Escaped string, array, object.
			 */
			public function esc_dq_deep($values, $times = 1)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->esc_dq_deep($_values, $times);
					unset($_key, $_values); // Housekeeping.

					return $values; // All done.
				}
				$string = (string)$values;
				$times  = abs((integer)$times);

				return str_replace('"', str_repeat('\\', $times).'"', $string);
			}

			/**
			 * Escape double quotes for CSV.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $string See {@link esc_csv_dq_deep()}.
			 * @param integer $times See {@link esc_csv_dq_deep()}.
			 *
			 * @return string See {@link esc_csv_dq_deep()}.
			 */
			public function esc_csv_dq($string, $times = 1)
			{
				return $this->esc_csv_dq_deep((string)$string, $times);
			}

			/**
			 * Escapes double quotes deeply; for CSV.
			 *
			 * @param mixed   $values Any value can be converted into an escaped string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @param integer $times Number of escapes. Defaults to `1`.
			 *
			 * @return string|array|object Escaped string, array, object.
			 */
			public function esc_csv_dq_deep($values, $times = 1)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->esc_csv_dq_deep($_values, $times);
					unset($_key, $_values); // Housekeeping.

					return $values; // All done.
				}
				$string = (string)$values;
				$times  = abs((integer)$times);

				return str_replace('"', str_repeat('"', $times).'"', $string);
			}

			/**
			 * String replace ONE time (caSe-insensitive).
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $needle See {@link str_replace_once_deep()}.
			 * @param string $replace See {@link str_replace_once_deep()}.
			 * @param string $string See {@link str_replace_once_deep()}.
			 *
			 * @return string See {@link str_replace_once_deep()}.
			 */
			public function ireplace_once($needle, $replace, $string)
			{
				return $this->replace_once_deep($needle, $replace, (string)$string, TRUE);
			}

			/**
			 * String replace ONE time deeply (caSe-insensitive).
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $needle See {@link replace_once_deep()}.
			 * @param string $replace See {@link replace_once_deep()}.
			 * @param mixed  $values See {@link replace_once_deep()}.
			 *
			 * @return string|array|object See {@link replace_once_deep()}.
			 */
			public function ireplace_once_deep($needle, $replace, $values)
			{
				return $this->replace_once_deep($needle, $replace, $values, TRUE);
			}

			/**
			 * String replace ONE time.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $needle See {@link str_replace_once_deep()}.
			 * @param string  $replace See {@link str_replace_once_deep()}.
			 * @param string  $string See {@link str_replace_once_deep()}.
			 * @param boolean $caSe_insensitive See {@link str_replace_once_deep()}.
			 *
			 * @return string See {@link str_replace_once_deep()}.
			 */
			public function str_replace_once($needle, $replace, $string, $caSe_insensitive = FALSE)
			{
				return $this->replace_once_deep($needle, $replace, (string)$string, $caSe_insensitive);
			}

			/**
			 * String replace ONE time deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $needle A string to search/replace.
			 * @param string  $replace What to replace `$needle` with.
			 * @param mixed   $values The haystack(s) to search in.
			 *
			 * @param boolean $caSe_insensitive Defaults to a `FALSE` value.
			 *    Pass this as `TRUE` to a caSe-insensitive search/replace.
			 *
			 * @return string|array|object The `$haystacks`, with `$needle` replaced with `$replace` ONE time only.
			 */
			public function replace_once_deep($needle, $replace, $values, $caSe_insensitive = FALSE)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->replace_once_deep($needle, $replace, $_values, $caSe_insensitive);
					unset($_key, $_values); // Housekeeping.

					return $values; // All done.
				}
				$needle  = (string)$needle;
				$replace = (string)$replace;
				$string  = (string)$values;

				$caSe_strpos = $caSe_insensitive ? 'stripos' : 'strpos';
				if(($needle_strpos = $caSe_strpos($string, $needle)) === FALSE)
					return $string; // Nothing to replace.

				return (string)substr_replace($string, $replace, $needle_strpos, strlen($needle));
			}

			/**
			 * Quote regex meta chars deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed       $values Input string(s) to mid-clip.
			 * @param null|string $delimiter Delimiter to use; if applicable.
			 *
			 * @return string|array|object Quoted string(s).
			 */
			public function preg_quote_deep($values, $delimiter = NULL)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->preg_quote_deep($_values, $delimiter);
					unset($_key, $_values); // Housekeeping.

					return $values; // All done.
				}
				$string = (string)$values;

				return preg_quote($string, $delimiter);
			}

			/**
			 * Normalizes end of line chars.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Any input string to normalize.
			 *
			 * @return string With normalized end of line chars.
			 */
			public function n_eols($string)
			{
				return $this->n_eols_deep((string)$string);
			}

			/**
			 * Normalizes end of line chars deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed $values Any value can be converted into a normalized string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object With normalized end of line chars deeply.
			 */
			public function n_eols_deep($values)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->n_eols_deep($_values);
					unset($_key, $_values); // Housekeeping.

					return $values; // All done.
				}
				$string = (string)$values;

				$string = str_replace(array("\r\n", "\r"), "\n", $string);
				$string = preg_replace('/'."\n".'{3,}/', "\n\n", $string);

				return $string; // With normalized line endings.
			}

			/**
			 * Normalizes HTML whitespace.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Any input string to normalize.
			 *
			 * @return string With normalized HTML whitespace.
			 */
			public function n_html_whitespace($string)
			{
				return $this->n_html_whitespace_deep((string)$string);
			}

			/**
			 * Normalizes HTML whitespace deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed $values Any value can be converted into a normalized string.
			 *    Actually, objects can't, but this recurses into objects.
			 *
			 * @return string|array|object With normalized HTML whitespace deeply.
			 */
			public function n_html_whitespace_deep($values)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->n_html_whitespace_deep($_values);
					unset($_key, $_values); // Housekeeping.

					return $this->n_eols_deep($values); // All done.
				}
				$string = (string)$values;

				if(is_null($whitespace = &$this->static_key(__FUNCTION__, 'whitespace')))
					$whitespace = implode('|', array_keys($this->html_whitespace));

				$string = preg_replace('/('.$whitespace.')('.$whitespace.')('.$whitespace.')+/i', '${1}${2}', $string);

				return $this->n_eols($string); // With normalized HTML whitespace.
			}

			/**
			 * Clips a string to X chars.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $string See {@link clip_deep()}.
			 * @param integer $max_length See {@link clip_deep()}.
			 * @param boolean $force_ellipsis See {@link clip_deep()}.
			 *
			 * @return string See {@link clip_deep()}.
			 */
			public function clip($string, $max_length = 45, $force_ellipsis = FALSE)
			{
				return $this->clip_deep((string)$string, $max_length, $force_ellipsis);
			}

			/**
			 * Clips string(s) to X chars deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed   $values Input string(s) to clip.
			 * @param integer $max_length Defaults to a value of `45`.
			 * @param boolean $force_ellipsis Defaults to a value of `FALSE`.
			 *
			 * @return string|array|object Clipped string(s).
			 */
			public function clip_deep($values, $max_length = 45, $force_ellipsis = FALSE)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->clip_deep($_values, $max_length, $force_ellipsis);
					unset($_key, $_values); // Housekeeping.

					return $values; // All done.
				}
				if(!($string = (string)$values))
					return $string; // Empty.

				$max_length = (integer)$max_length;
				$max_length = $max_length < 4 ? 4 : $max_length;

				$string = $this->html_to_text($string, array('br2nl' => FALSE));

				if(strlen($string) > $max_length)
					$string = (string)substr($string, 0, $max_length - 3).'...';

				else if($force_ellipsis && strlen($string) + 3 > $max_length)
					$string = (string)substr($string, 0, $max_length - 3).'...';

				else $string .= $force_ellipsis ? '...' : '';

				return $string; // Clipped.
			}

			/**
			 * Mid-clips a string to X chars.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $string See {@link mid_clip_deep()}.
			 * @param integer $max_length See {@link mid_clip_deep()}
			 *
			 * @return string See {@link mid_clip_deep()}
			 */
			public function mid_clip($string, $max_length = 45)
			{
				return $this->mid_clip_deep((string)$string, $max_length);
			}

			/**
			 * Mid-clips string(s) to X chars deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed   $values Input string(s) to mid-clip.
			 * @param integer $max_length Defaults to a value of `45`.
			 *
			 * @return string|array|object Mid-clipped string(s).
			 */
			public function mid_clip_deep($values, $max_length = 45)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->mid_clip_deep($_values, $max_length);
					unset($_key, $_values); // Housekeeping.

					return $values; // All done.
				}
				if(!($string = (string)$values))
					return $string; // Empty.

				$max_length = (integer)$max_length;
				$max_length = $max_length < 4 ? 4 : $max_length;

				$string = $this->html_to_text($string, array('br2nl' => FALSE));

				if(strlen($string) <= $max_length)
					return $string; // Nothing to do.

				$full_string     = $string;
				$half_max_length = floor($max_length / 2);

				$first_clip = $half_max_length - 3;
				$string     = ($first_clip >= 1) // Something?
					? substr($full_string, 0, $first_clip).'...'
					: '...'; // Ellipsis only.

				$second_clip = strlen($full_string) - ($max_length - strlen($string));
				$string .= ($second_clip >= 0 && $second_clip >= $first_clip)
					? substr($full_string, $second_clip) : ''; // Nothing more.

				return $string; // Mid-clipped.
			}

			/**
			 * Is a string in HTML format?
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Any input string to test here.
			 *
			 * @return boolean TRUE if string is HTML.
			 */
			public function is_html($string)
			{
				if(!$string || !is_string($string))
					return FALSE; // Not possible.

				return strpos($string, '<') !== FALSE && preg_match('/\<[^<>]+\>/', $string);
			}

			/**
			 * Encodes all HTML entities.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $string Any input string to encode.
			 * @param boolean $double Double encode existing HTML entities?
			 *
			 * @return string String w/ HTML entities encoded.
			 */
			public function html_entities_encode($string, $double = FALSE)
			{
				if(!($string = trim((string)$string)))
					return $string; // Not possible.

				$decode_flags = ENT_QUOTES;

				if(defined('ENT_HTML5')) // PHP 5.4+ only.
					$decode_flags |= ENT_HTML5;
				else $decode_flags |= ENT_HTML401;

				$string = wp_check_invalid_utf8($string);

				return htmlentities($string, $decode_flags, 'UTF-8', (boolean)$double);
			}

			/**
			 * Decodes all HTML entities.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Any input string to decode.
			 *
			 * @return string String w/ HTML entities decoded.
			 */
			public function html_entities_decode($string)
			{
				if(!($string = trim((string)$string)))
					return $string; // Not possible.

				$decode_flags = ENT_QUOTES;

				if(defined('ENT_HTML5')) // PHP 5.4+ only.
					$decode_flags |= ENT_HTML5;
				else $decode_flags |= ENT_HTML401;

				$string = wp_check_invalid_utf8($string);

				return html_entity_decode($string, $decode_flags, 'UTF-8');
			}

			/**
			 * Convert plain text to HTML markup.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Input string to convert.
			 *
			 * @return string Plain text converted to HTML markup.
			 */
			public function text_to_html($string)
			{
				if(!($string = trim((string)$string)))
					return $string; // Not possible.

				$string = esc_html($string);
				$string = $this->html_entities_encode($string);
				$string = nl2br($this->n_eols($string));

				$string = make_clickable($string);
				$string = $this->trim_html($this->n_html_whitespace($string));

				return $string; // HTML markup now.
			}

			/**
			 * Convert HTML markup converted to plain text.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Input string to convert.
			 * @param array  $args Any additional behavioral args.
			 *
			 * @return string HTML markup converted to plain text.
			 */
			public function html_to_text($string, array $args = array())
			{
				if(!($string = trim((string)$string)))
					return $string; // Not possible.

				$default_args = array(
					'br2nl'                 => TRUE,

					'strip_content_in_tags' => $this->invisible_tags,
					'inject_eol_after_tags' => $this->block_tags,
				);
				$args         = array_merge($default_args, $args);
				$args         = array_intersect_key($args, $default_args);

				$br2nl = (boolean)$args['br2nl']; // Allow line breaks?

				$strip_content_in_tags            = (array)$args['strip_content_in_tags'];
				$strip_content_in_tags_regex_frag = implode('|', $this->preg_quote_deep($strip_content_in_tags));

				$inject_eol_after_tags            = (array)$args['inject_eol_after_tags'];
				$inject_eol_after_tags_regex_frag = implode('|', $this->preg_quote_deep($inject_eol_after_tags));

				$string = preg_replace('/\<('.$strip_content_in_tags_regex_frag.')(?:\>|\s[^>]*\>).*?\<\/\\1\>/is', '', $string);
				$string = preg_replace('/\<\/(?:'.$inject_eol_after_tags_regex_frag.')\>/i', '${0}'."\n", $string);
				$string = preg_replace('/\<(?:'.$inject_eol_after_tags_regex_frag.')(?:\/\s*\>|\s[^\/>]*\/\s*\>)/i', '${0}'."\n", $string);

				$string = strip_tags($string, $br2nl ? '<br>' : '');
				$string = $this->html_entities_decode($string);
				$string = str_replace("\xC2\xA0", ' ', $string);

				if($br2nl) // Allow line breaks in this case.
				{
					$string = preg_replace('/\<br(?:\>|\/\s*\>|\s[^\/>]*\/\s*\>)/', "\n", $string);
					$string = $this->n_eols($string); // Normalize line breaks.
					$string = preg_replace('/[ '."\t\x0B".']+/', ' ', $string);
				}
				else $string = preg_replace('/\s+/', ' ', $string); // One line only.

				$string = trim($string); // Trim things up now.

				return $string; // Plain text now.
			}

			/**
			 * Convert HTML to rich text; w/ allowed tags only.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Input string to convert.
			 * @param array  $args Any additional behavioral args.
			 *
			 * @return string HTML to rich text; w/ allowed tags only.
			 */
			public function html_to_rich_text($string, array $args = array())
			{
				if(!($string = trim((string)$string)))
					return $string; // Not possible.

				$default_args = array(
					'br2nl'                 => TRUE,

					'allowed_tags'          => array(
						'a',
						'strong', 'b',
						'i', 'em',
						'ul', 'ol', 'li',
						'code', 'pre',
						'q', 'blockquote',
					),
					'allowed_attributes'    => array(
						'href',
					),

					'strip_content_in_tags' => $this->invisible_tags,
					'inject_eol_after_tags' => $this->block_tags,
				);
				$args         = array_merge($default_args, $args);
				$args         = array_intersect_key($args, $default_args);

				$br2nl = (boolean)$args['br2nl']; // Allow line breaks?

				$allowed_tags = (array)$args['allowed_tags'];
				if($br2nl) $allowed_tags[] = 'br'; // Allow `<br>` in this case.
				$allowed_tags       = array_unique(array_map('strtolower', $allowed_tags));
				$allowed_attributes = (array)$args['allowed_attributes'];

				$strip_content_in_tags            = (array)$args['strip_content_in_tags'];
				$strip_content_in_tags            = array_map('strtolower', $strip_content_in_tags);
				$strip_content_in_tags            = array_diff($strip_content_in_tags, $allowed_tags);
				$strip_content_in_tags_regex_frag = implode('|', $this->preg_quote_deep($strip_content_in_tags));

				$inject_eol_after_tags            = (array)$args['inject_eol_after_tags'];
				$inject_eol_after_tags            = array_map('strtolower', $inject_eol_after_tags);
				$inject_eol_after_tags            = array_diff($inject_eol_after_tags, $allowed_tags);
				$inject_eol_after_tags_regex_frag = implode('|', $this->preg_quote_deep($inject_eol_after_tags));

				$string = preg_replace('/\<('.$strip_content_in_tags_regex_frag.')(?:\>|\s[^>]*\>).*?\<\/\\1\>/is', '', $string);
				$string = preg_replace('/\<\/(?:'.$inject_eol_after_tags_regex_frag.')\>/i', '${0}'."\n", $string);
				$string = preg_replace('/\<(?:'.$inject_eol_after_tags_regex_frag.')(?:\/\s*\>|\s[^\/>]*\/\s*\>)/i', '${0}'."\n", $string);

				$string = strip_tags($string, $allowed_tags ? '<'.implode('><', $allowed_tags).'>' : '');
				$string = $this->strip_html_attributes($string, compact('allowed_attributes'));
				$string = force_balance_tags($string); // Force balanced HTML tags.

				if($br2nl) // Allow line breaks in this case.
				{
					$string = preg_replace('/\<br(?:\>|\/\s*\>|\s[^\/>]*\/\s*\>)/', "\n", $string);
					$string = $this->n_eols($string); // Normalize line breaks.
					$string = preg_replace('/[ '."\t\x0B".']+/', ' ', $string);
				}
				else $string = preg_replace('/\s+/', ' ', $string); // One line only.

				$string = $this->trim_html($this->n_html_whitespace($string));

				return $string; // Rich text markup now.
			}

			/**
			 * Strips HTML attributes.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Any input string to strip.
			 * @param array  $args Any additional behavioral args.
			 *
			 * @return string String w/ HTML attributes stripped.
			 */
			public function strip_html_attributes($string, array $args = array())
			{
				$default_args = array(
					'allowed_attributes' => array(),
				);
				$args         = array_merge($default_args, $args);
				$args         = array_intersect_key($args, $default_args);

				$allowed_attributes = // Force lowercase.
					array_map('strtolower', (array)$args['allowed_attributes']);

				$regex_tags  = '/(?P<open>\<[\w\-]+)(?P<attrs>[^>]+)(?P<close>\>)/i';
				$regex_attrs = '/\s+(?P<attr>[\w\-]+)(?:\s*\=\s*(["\']).*?\\2|\s*\=[^\s]*)?/is';

				return preg_replace_callback($regex_tags, function ($m) use ($allowed_attributes, $regex_attrs)
				{
					return $m['open'].preg_replace_callback($regex_attrs, function ($m) use ($allowed_attributes)
					{
						return in_array(strtolower($m['attr']), $allowed_attributes, TRUE) ? $m[0] : '';
					}, $m['attrs']).$m['close']; // With modified attributes.

				}, $string); // Removes attributes; leaving only those allowed explicitly.
			}

			/**
			 * A very simple markdown parser.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string Input string to convert.
			 * @param array  $args Any additional behavioral args.
			 *
			 * @return string Markdown converted to HTML markup.
			 */
			public function markdown($string, array $args = array())
			{
				if(!($string = trim((string)$string)))
					return $string; // Not possible.

				$default_args = array(
					'no_p' => FALSE,
				);
				$args         = array_merge($default_args, $args);
				$args         = array_intersect_key($args, $default_args);

				$no_p = (boolean)$args['no_p'];

				if(!class_exists('\\Parsedown')) // Need Parsedown class here.
					require_once dirname(dirname(dirname(__FILE__))).'/submodules/parsedown/Parsedown.php';

				if(is_null($parsedown = &$this->cache_key(__FUNCTION__, 'parsedown')))
					/** @var $parsedown \Parsedown Reference for IDEs. */
					$parsedown = new \Parsedown(); // Single instance.

				$html = $parsedown->text($string);

				if($no_p) // Remove `<p></p>` wrap?
				{
					$html = preg_replace('/^\<p\>/i', '', $html);
					$html = preg_replace('/\<\/p\>$/i', '', $html);
				}
				return $html; // Gotta love Parsedown :-)
			}

			/**
			 * A very simple markdown parser.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string See {@link markdown()}.
			 * @param array  $args See {@link markdown()}.
			 *
			 * @return string See {@link markdown()}.
			 */
			public function markdown_no_p($string, array $args = array())
			{
				return $this->markdown($string, array_merge($args, array('no_p' => TRUE)));
			}

			/**
			 * Get first name from a full name, user, or email address.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string                       $name The full name; or display name.
			 *
			 * @param \WP_User|integer|string|null $user_id_email A WP User object, WP user ID, or email address.
			 *    If provided, we make every attempt to pull a name from this source.
			 *
			 * @param integer                      $max_length The maximum length of the name.
			 *
			 * @return string First name, else full name; else whatever we can get from `$user_id_email`.
			 */
			public function first_name($name = '', $user_id_email = NULL, $max_length = 50)
			{
				$name       = $this->clean_name($name);
				$max_length = abs((integer)$max_length);

				if($name && strpos($name, ' ', 1) !== FALSE)
					list($fname,) = explode(' ', $name, 2);
				else $fname = $name; // One part in this case.

				if($fname && ($fname = (string)substr(trim($fname), 0, $max_length)))
					return $fname; // All set; nothing more to do here.

				if(($user = $user_id_email) instanceof \WP_User
				   || (is_integer($user_id_email) && ($user = new \WP_User($user_id_email)))
				) // Find first non-empty data values (in order of precedence).
				{
					$name  = $this->coalesce($user->first_name, $user->display_name, $user->user_login);
					$email = $this->coalesce($user->user_email);

					if($name || $email) // Only if we got something.
						return $this->first_name($name, $email, $max_length);
				}
				else if(is_string($user_id_email) && ($email = $user_id_email))
					return $this->email_name($email, $max_length);

				return ''; // Default value; i.e. failure.
			}

			/**
			 * Name from email address.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string  $string Input email address.
			 * @param integer $max_length The maximum length of the name.
			 *
			 * @return string Name from email address; else an empty string.
			 */
			public function email_name($string, $max_length = 50)
			{
				if(!($string = trim((string)$string)))
					return ''; // Not possible.

				$max_length = abs((integer)$max_length);

				return (string)ucfirst(substr(strstr($string, '@', TRUE), 0, $max_length));
			}

			/**
			 * Get last name from a full name or user.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string                $name The full name; or display name.
			 *
			 * @param \WP_User|integer|null $user_id A WP User object, or WP user ID.
			 *    If provided, we make every attempt to pull a name from this source.
			 *
			 * @param integer               $max_length The maximum length of the name.
			 *
			 * @return string First name, else full name; else whatever we can get from `$user_id_email`.
			 */
			public function last_name($name = '', $user_id = NULL, $max_length = 100)
			{
				$name       = $this->clean_name($name);
				$max_length = abs((integer)$max_length);

				if($name && strpos($name, ' ', 1) !== FALSE)
					list(, $lname) = explode(' ', $name, 2);
				else $lname = ''; // One part in this case.

				if($lname && ($lname = (string)substr(trim($lname), 0, $max_length)))
					return $lname; // All set; nothing more to do here.

				if(($user = $user_id) instanceof \WP_User
				   || (is_integer($user_id) && ($user = new \WP_User($user_id)))
				) // Find first non-empty data values (in order of precedence).
				{
					if(($lname = $user->last_name))
						return ($lname = (string)substr(trim($lname), 0, $max_length));

					if(($name = $this->coalesce($user->display_name)))
						return $this->last_name($name, NULL, $max_length);
				}
				return ''; // Default value; i.e. failure.
			}

			/**
			 * Cleans a full name.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param string $string See {@link clean_names_deep()}.
			 *
			 * @return string See {@link clean_names_deep()}.
			 */
			public function clean_name($string)
			{
				return $this->clean_names_deep((string)$string);
			}

			/**
			 * Cleans full name(s) deeply.
			 *
			 * @since 141111 First documented version.
			 *
			 * @param mixed $values Input name(s) to clean.
			 *
			 * @return string|array|object Having cleaned name(s) deeply.
			 */
			public function clean_names_deep($values)
			{
				if(is_array($values) || is_object($values))
				{
					foreach($values as $_key => &$_values)
						$_values = $this->clean_names_deep($_values);
					unset($_values); // Housekeeping.

					return $values; // All done.
				}
				$string = trim((string)$values); // Trim string.
				$string = $string ? str_replace('"', '', $string) : '';
				$string = $string ? preg_replace('/^(?:Mr\.?|Mrs\.?|Ms\.?|Dr\.?)\s+/i', '', $string) : '';
				$string = $string ? preg_replace('/\s+(?:Sr\.?|Jr\.?|IV|I+)$/i', '', $string) : '';
				$string = $string ? preg_replace('/\s+/', ' ', $string) : '';
				$string = $string ? trim($string) : ''; // Trim again.

				return $string; // Cleaned up now.
			}

			/**
			 * HTML whitespace. Keys are actually regex patterns here.
			 *
			 * @var array HTML whitespace. Keys are actually regex patterns here.
			 */
			public $html_whitespace = array(
				'\0'                      => "\0",
				'\x0B'                    => "\x0B",
				'\s'                      => "\r\n\t ",
				'\xC2\xA0'                => "\xC2\xA0",
				'&nbsp;'                  => '&nbsp;',
				'\<br\>'                  => '<br>',
				'\<br\s*\/\>'             => '<br/>',
				'\<p\>(?:&nbsp;)*\<\/p\>' => '<p></p>'
			);

			/**
			 * HTML5 invisible tags.
			 *
			 * @var array HTML5 invisible tags.
			 */
			public $invisible_tags = array(
				'head',
				'title',
				'style',
				'script',
			);

			/**
			 * HTML5 block-level tags.
			 *
			 * @var array HTML5 block-level tags.
			 */
			public $block_tags = array(
				'address',
				'article',
				'aside',
				'audio',
				'blockquote',
				'canvas',
				'dd',
				'div',
				'dl',
				'fieldset',
				'figcaption',
				'figure',
				'footer',
				'form',
				'h1',
				'h2',
				'h3',
				'h4',
				'h5',
				'h6',
				'header',
				'hgroup',
				'hr',
				'noscript',
				'ol',
				'output',
				'p',
				'pre',
				'section',
				'table',
				'tfoot',
				'ul',
				'video',
			);
		}
	}
}