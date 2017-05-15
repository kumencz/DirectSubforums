<?php
/**
 *
 * Show only direct subforums. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, kumen, https://github.com/kumencz
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace kumen\DirectSubforums\event;

/**
 * @ignore
 */
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Show only direct subforums Event listener.
 */
class main_listener implements EventSubscriberInterface
{
	static public function getSubscribedEvents()
	{
		return array(
			'core.display_forums_modify_forum_rows'	=> 'drop_subforums',
		);
	}

	/**
	 * A sample PHP event
	 * Modifies the names of the forums on index
	 *
	 * @param \phpbb\event\data	$event	Event object
	 */
	public function drop_subforums($event)
	{
		$row = $event['row'];
		$parent_id = $event['parent_id'];
		$subforums = $event['subforums'];
		if($row['forum_type'] != FORUM_CAT && $parent_id != $row['parent_id'])
		{
			unset($subforums[$parent_id][$row['forum_id']]);
		}

		if (isset($subforums[$parent_id][$row['parent_id']]) && !$row['display_on_index'])
		{
			unset($subforums[$parent_id][$row['parent_id']]['children']);
		}
		$event['subforums'] = $subforums;
	}
}
