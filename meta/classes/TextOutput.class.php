<?php
/***************************************************************************
 *   Copyright (C) 2006 by Konstantin V. Arkhipov                          *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU General Public License as published by  *
 *   the Free Software Foundation; either version 2 of the License, or     *
 *   (at your option) any later version.                                   *
 *                                                                         *
 ***************************************************************************/
/* $Id$ */

	/**
	 * @ingroup MetaBase
	**/
	class TextOutput
	{
		/**
		 * @return TextOutput
		**/
		public function write($text)
		{
			echo $text;
			
			return $this;
		}
		
		/**
		 * @return TextOutput
		**/
		public function writeLine($text)
		{
			echo $text."\n";
			
			return $this;
		}
		
		/**
		 * @return TextOutput
		**/
		public function newLine()
		{
			echo "\n";
			
			return $this;
		}
		
		/**
		 * @return TextOutput
		**/
		public function setMode(
			$attribute = ConsoleMode::ATTR_RESET_ALL,
			$foreground = ConsoleMode::FG_WHITE,
			$background = ConsoleMode::BG_BLACK
		)
		{
			// nop
			
			return $this;
		}
		
		/**
		 * @return TextOutput
		**/
		public function resetAll()
		{
			// nop
			
			return $this;
		}
	}
?>