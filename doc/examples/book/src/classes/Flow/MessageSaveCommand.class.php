<?php
/***************************************************************************
 *   Copyright (C) 2007 by Denis Gabaidulin                                *
 *   gabaden@gmail.com                                                     *
 ***************************************************************************/
/* $Id$ */

	final class MessageSaveCommand extends SaveCommand
	{
		public function run(
			Prototyped $subject, Form $form, HttpRequest $request
		)
		{
			$form->importValue(
				'created',
				$form->getValue('id')->getCreated()
			);
			
			return parent::run($subject, $form, $request);
		}
	}
?>