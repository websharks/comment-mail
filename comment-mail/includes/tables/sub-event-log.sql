CREATE TABLE IF NOT EXISTS `%%prefix%%sub_event_log` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Primary key.',
  `sub_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Subscriber ID from the `subs` table; at the time of the event. The subscriber may or may not still exist.',
  `oby_sub_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Overwritten by subscriber ID from the `subs` table? The subscriber may or may not still exist.',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'User ID from the `wp_users` table; at the time of the event, if applicable. The user may or may not still exist.',
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Post ID from the `wp_posts` table; at the time of the event. The post may or may not still exist.',
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT 'Comment ID from the `wp_comments` table; at the time of the event, if applicable. The comment may or may not still exist.',
  `deliver` enum('asap','hourly','daily','weekly') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Delivery option; at the time of the event.',
  `fname` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'First name; at the time of the event.',
  `lname` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Last name; at the time of the event.',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Email address; at the time of the event.',
  `ip` varchar(39) COLLATE utf8_unicode_ci NOT NULL COMMENT 'IP address; at the time of the event.',
  `status_before` enum('','unconfirmed','subscribed','suspended','trashed','deleted') COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'Subscription status; before the event.',
  `status` enum('unconfirmed','subscribed','suspended','trashed','deleted') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Subscription status; at the time of the event.',
  `event` enum('inserted','updated','overwritten','purged','cleaned','deleted') COLLATE utf8_unicode_ci NOT NULL COMMENT 'Event type.',
  `user_initiated` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'This event was user initiated, or no?',
  `time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Event time. Unix timestamp.',
  PRIMARY KEY (`ID`) COMMENT 'Primary key.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;