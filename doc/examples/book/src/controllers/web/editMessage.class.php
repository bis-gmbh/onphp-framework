<?php
/***************************************************************************
 *   Copyright (C) 2007 by Denis Gabaidulin                                *
 *   gabaden@gmail.com                                                     *
 ***************************************************************************/
/* $Id$ */

	final class editMessage extends baseEditMessage
	{
		public function	handleRequest(HttpRequest $request)
		{
			// a bit of paranoya
			$form =
				Form::create()->
				add(
					Primitive::string('action')->
					required()
				)->
				importOne('action', $request->getGet());
				
			if ($form->getErrors())
				return
					ModelAndView::create()->
					setView(BaseEditor::COMMAND_FAILED);
			
			if (
				$form->getValue('action') != 'add'
			)
				return
					ModelAndView::create()->
					setView(BaseEditor::COMMAND_FAILED);
				
			return parent::handleRequest($request);
		}
	}
?>