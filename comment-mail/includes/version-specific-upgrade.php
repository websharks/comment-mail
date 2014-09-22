<?php
/**
 * Version-Specific Upgrade
 *
 * @package version_specific_upgrade
 * @since 14xxxx First documented version.
 * @copyright WebSharks, Inc. <http://www.websharks-inc.com>
 * @license GNU General Public License, version 3
 */
namespace comment_mail // Root namespace.
{
	if(!defined('WPINC')) // MUST have WordPress.
		exit('Do NOT access this file directly: '.basename(__FILE__));

	require_once dirname(__FILE__).'/plugin.inc.php';

	if(!class_exists('\\'.__NAMESPACE__.'\\version_specific_upgrade'))
	{
		/**
		 * Version-Specific Upgrade
		 *
		 * @package version_specific_upgrade
		 * @since 14xxxx First documented version.
		 */
		class version_specific_upgrade
		{
			/**
			 * @var plugin Plugin reference.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected $plugin; // Set by constructor.

			/**
			 * @var string Version they are upgrading from.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected $prev_version = ''; // Set by constructor.

			/**
			 * Class constructor.
			 *
			 * @since 14xxxx First documented version.
			 *
			 * @param string $prev_version Version they are upgrading from.
			 */
			public function __construct($prev_version)
			{
				$this->plugin       = plugin();
				$this->prev_version = (string)$prev_version;
				$this->run_handlers(); // Run upgrade(s).
			}

			/**
			 * Runs upgrade handlers in the proper order.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected function run_handlers()
			{
				$this->from_lt_vxxxx();
			}

			/**
			 * Upgrading from a version prior to our rewrite.
			 *
			 * @since 14xxxx First documented version.
			 */
			protected function from_lt_vxxxx()
			{
			}
		}
	}
}