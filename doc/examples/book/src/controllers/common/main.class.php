<?php
/***************************************************************************
 *   Copyright (C) 2007 by Denis Gabaidulin                                *
 *   gabaden@gmail.com                                                     *
 ***************************************************************************/
/* $Id$ */

	final class main implements Controller
	{
		public function handleRequest(HttpRequest $request)
		{
			$form =
				Form::create()->
				add(
					Primitive::identifier('category')->
					of('Category')->
					optional()
				)->
				import($request->getGet());
			
			if ($form->getErrors())
				return
					ModelAndView::create()->
					setView('error');
			
			$criteria =
				Criteria::create(Message::dao())->
				addOrder(
					OrderBy::create('created')->
					desc()
				);
			
			if ($form->getValue('category'))
				$criteria->add(
					Expression::eq(
						'Category',
						$form->getValue('category')
					)
				);
			
			$messages = $criteria->getList();
			
			return
				ModelAndView::create()->
				setModel(
					Model::create()->
					set('currentCategory', $form->getValue('category'))->
					set('messages', $messages)
				);
		}
	}
?>