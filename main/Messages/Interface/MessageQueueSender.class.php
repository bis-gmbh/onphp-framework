<?php
/***************************************************************************
 *   Copyright (C) 2009 by Ivan Y. Khvostishkov                            *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 *                                                                         *
 ***************************************************************************/

	namespace Onphp;

	interface MessageQueueSender
	{
		/**
		 * @return \Onphp\MessageQueueReceiver
		**/
		public function send(Message $message);
		
		/**
		 * @return \Onphp\MessageQueue
		**/
		public function getQueue();
	}
?>