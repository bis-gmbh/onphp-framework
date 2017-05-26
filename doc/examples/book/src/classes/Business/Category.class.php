<?php
/*****************************************************************************
 *   Copyright (C) 2006-2007, onPHP's MetaConfiguration Builder.             *
 *   Generated by onPHP-0.10.3.99 at 2007-09-07 23:04:52                     *
 *   This file will never be generated again - feel free to edit.            *
 *****************************************************************************/
/* $Id$ */

	final class Category extends AutoCategory implements Prototyped, DAOConnected
	{
		const DEFAULT_CATEGORY = 1;
		
		/**
		 * @return Category
		**/
		public static function create()
		{
			return new self;
		}
		
		/**
		 * @return CategoryDAO
		**/
		public static function dao()
		{
			return Singleton::getInstance('CategoryDAO');
		}
		
		/**
		 * @return ProtoCategory
		**/
		public static function proto()
		{
			return Singleton::getInstance('ProtoCategory');
		}
	}
?>