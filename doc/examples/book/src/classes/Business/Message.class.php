<?php
/*****************************************************************************
 *   Copyright (C) 2006-2007, onPHP's MetaConfiguration Builder.             *
 *   Generated by onPHP-0.10.3.99 at 2007-09-07 23:04:52                     *
 *   This file will never be generated again - feel free to edit.            *
 *****************************************************************************/
/* $Id$ */

	final class Message extends AutoMessage implements Prototyped, DAOConnected
	{
		/**
		 * @return Message
		**/
		public static function create()
		{
			return new self;
		}
		
		/**
		 * @return MessageDAO
		**/
		public static function dao()
		{
			return Singleton::getInstance('MessageDAO');
		}
		
		/**
		 * @return ProtoMessage
		**/
		public static function proto()
		{
			return Singleton::getInstance('ProtoMessage');
		}
		
		// your brilliant stuff goes here
	}
?>