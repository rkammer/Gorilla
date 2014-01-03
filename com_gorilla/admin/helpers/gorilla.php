<?php
defined('_JEXEC') or die;

class GorillaHelper
{
	public static function getActions($categoryId = 0)
	{
		$user = JFactory::getUser();
		$result = new JObject;
		
		if (empty($categoryId))
		{
			$assetName = 'com_gorilla';
			$level = 'component';
		}
		else
		{
			$assetName = 'com_gorilla.category.'.(int) $categoryId;
			$level = 'category';
		}
		
		$actions = JAccess::getActions('com_gorilla', $level);
		foreach ($actions as $action)
		{
			$result->set($action->name, $user->authorise($action->name, $assetName));
		}
		
		return $result;
	}
}