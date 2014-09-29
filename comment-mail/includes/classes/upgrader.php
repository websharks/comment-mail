<?php
/**
 * Upgrade Routines
 *
 * @package upgrader
 * @since 14xxxx First documented version.
 * @copyright WebSharks, Inc. <http://www.websharks-inc.com>
 * @license GNU General Public License, version 3
 */
namespace comment_mail // Root namespace.
{
	if(!defined('WPINC')) // MUST have WordPress.
		exit('Do NOT access this file directly: '.basename(__FILE__));

	if(!class_exists('\\'.__NAMESPACE__.'\\upgrader'))
	{
		/**
		 * Upgrade Routines
		 *
		 * @package upgrader
		 * @since 14xxxx First documented version.
		 */
		class upgrader
		{
			/**
			 * @var plugin Plugin reference.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected $plugin; // Set by constructor.

			/**
			 * @var string Current version.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected $current_version; // Set by constructor.

			/**
			 * @var string Previous version.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected $prev_version; // Set by constructor.

			/**
			 * Class constructor.
			 *
			 * @since 14xxxx First documented version.
			 */
			public function __construct()
			{
				$this->plugin = plugin();

				$this->current_version = $this->plugin->options['version'];
				$this->prev_version    = $this->plugin->options['version'];

				$this->maybe_upgrade();
			}

			/**
			 * Upgrade routine(s).
			 *
			 * @since 14xxxx First documented version.
			 */
			protected function maybe_upgrade()
			{
				if(version_compare($this->current_version, $this->plugin->version, '>='))
					return; // Nothing to do; already @ latest version.

				$this->plugin->options['version'] = $this->current_version = $this->plugin->version;
				update_option(__NAMESPACE__.'_options', $this->plugin->options);

				new upgrader_vs($this->prev_version); // Run version-specific upgrader(s).

				$notice = __('<strong>%1$s</strong> detected a new version of itself. Recompiling... All done :-)', $this->plugin->text_domain);

				$this->plugin->enqueue_notice(sprintf($notice, esc_html($this->plugin->name)), '', TRUE); // Push this to the top.
			}
		}
	}
}