<?php
/***************************************************************************
 *   Copyright (C) 2007 by Denis Gabaidulin                                *
 *   gabaden@gmail.com                                                     *
 ***************************************************************************/
/* $Id$ */

	final class MessageAddCommand extends AddCommand
	{
		public function run(
			Prototyped $subject, Form $form, HttpRequest $request
		)
		{
			$form->
				importValue(
					'created',
					Timestamp::makeNow()
				);
			
			return parent::run($subject, $form, $request);
		}
	}
?>