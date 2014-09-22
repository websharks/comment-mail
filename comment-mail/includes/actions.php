<?php
/**
 * Action Handlers
 *
 * @package actions
 * @since 14xxxx First documented version.
 * @copyright WebSharks, Inc. <http://www.websharks-inc.com>
 * @license GNU General Public License, version 3
 */
namespace comment_mail // Root namespace.
{
	if(!defined('WPINC')) // MUST have WordPress.
		exit('Do NOT access this file directly: '.basename(__FILE__));

	require_once dirname(__FILE__).'/plugin.inc.php';

	if(!class_exists('\\'.__NAMESPACE__.'\\actions'))
	{
		/**
		 * Action Handlers
		 *
		 * @package actions
		 * @since 14xxxx First documented version.
		 */
		class actions // Action handlers.
		{
			/**
			 * @var plugin Plugin reference.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected $plugin; // Set by constructor.

			/**
			 * Class constructor.
			 *
			 * @since 14xxxx First documented version.
			 */
			public function __construct()
			{
				$this->plugin = plugin();

				if(empty($_REQUEST[__NAMESPACE__]))
					return; // Nothing to do.

				if(!current_user_can($this->plugin->cap))
					return; // Unauthenticated; ignore.

				if(empty($_REQUEST['_wpnonce']) || !wp_verify_nonce($_REQUEST['_wpnonce']))
					return; // Unauthenticated; ignore.

				foreach((array)$_REQUEST[__NAMESPACE__] as $action => $args)
					if($action && is_string($action) && method_exists($this, $action))
						$this->{$action}($this->plugin->trim_strip_deep($args));
			}

			/**
			 * Restores defaults options.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected function restore_default_options()
			{
				delete_option(__NAMESPACE__.'_options');
				$this->plugin->options = $this->plugin->default_options;

				$redirect_to = self_admin_url('/admin.php');
				$query_args  = array('page' => __NAMESPACE__, __NAMESPACE__.'__restored' => '1');
				$redirect_to = add_query_arg(urlencode_deep($query_args), $redirect_to);

				wp_redirect($redirect_to).exit();
			}

			/**
			 * Saves options.
			 *
			 * @since 14xxxx First documented version.
			 *
			 * @param array $args Input array of all arguments.
			 */
			protected function save_options(array $args)
			{
				$this->plugin->options = array_merge($this->plugin->default_options, $this->plugin->options, $args);
				$this->plugin->options = array_intersect_key($this->plugin->options, $this->plugin->default_options);
				update_option(__NAMESPACE__.'_options', $this->plugin->options);

				$redirect_to = self_admin_url('/admin.php');
				$query_args  = array('page' => __NAMESPACE__, __NAMESPACE__.'__updated' => '1');
				$redirect_to = add_query_arg(urlencode_deep($query_args), $redirect_to);

				wp_redirect($redirect_to).exit();
			}

			/**
			 * Dismisses a persistent notice.
			 *
			 * @since 14xxxx First documented version.
			 *
			 * @param array $args Input array of all arguments.
			 */
			protected function dismiss_notice(array $args)
			{
				if(empty($args['key'])) // Missing key?
					return; // Nothing to dismiss.

				$notices = (is_array($notices = get_option(__NAMESPACE__.'_notices'))) ? $notices : array();
				unset($notices[$args['key']]); // Dismiss this notice.
				update_option(__NAMESPACE__.'_notices', $notices);

				wp_redirect(remove_query_arg(__NAMESPACE__)).exit();
			}

			/**
			 * Dismisses a persistent error.
			 *
			 * @since 14xxxx First documented version.
			 *
			 * @param array $args Input array of all arguments.
			 */
			protected function dismiss_error(array $args)
			{
				if(empty($args['key'])) // Missing key?
					return; // Nothing to dismiss.

				$errors = (is_array($errors = get_option(__NAMESPACE__.'_errors'))) ? $errors : array();
				unset($errors[$args['key']]); // Dismiss this error.
				update_option(__NAMESPACE__.'_errors', $errors);

				wp_redirect(remove_query_arg(__NAMESPACE__)).exit();
			}
		}
	}
}