<?php
/*****************************************************************************
 *   Copyright (C) 2006-2007, onPHP's MetaConfiguration Builder.             *
 *   Generated by onPHP-0.9.300 at 2007-05-15 14:27:41                       *
 *   This file will never be generated again - feel free to edit.            *
 *****************************************************************************/
/* $Id$ */

	final class StatisticQuery extends AutoStatisticQuery implements Prototyped, DAOConnected
	{
		/**
		 * @return StatisticQuery
		**/
		public static function create()
		{
			return new self;
		}
		
		/**
		 * @return StatisticQueryDAO
		**/
		public static function dao()
		{
			return Singleton::getInstance('StatisticQueryDAO');
		}
		
		/**
		 * @return ProtoStatisticQuery
		**/
		public static function proto()
		{
			return Singleton::getInstance('ProtoStatisticQuery');
		}
		
		// your brilliant stuff goes here
	}
?>