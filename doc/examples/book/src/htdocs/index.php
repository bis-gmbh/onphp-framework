<?php
	/**
	 * $Id$
	**/
	
	define('DEFAULT_CONTROLLER', 'main');
	
	require '../config.inc.php';
	
	define('PATH_WEB_CSS', PATH_WEB.'css/');
	define('PATH_WEB_IMG', PATH_WEB.'img/');
	
	ini_set(
		'include_path',
		get_include_path().PATH_SEPARATOR
			.PATH_CONTROLLERS.'common'.DIRECTORY_SEPARATOR.PATH_SEPARATOR
			.PATH_CONTROLLERS.'web'.DIRECTORY_SEPARATOR.PATH_SEPARATOR
	);
	
	try {
		$request =
			HttpRequest::create()->
			setGet($_GET)->
			setPost($_POST)->
			setCookie($_COOKIE)->
			setServer($_SERVER)->
			setSession($_SESSION)->
			setFiles($_FILES);
		
		$request->setAttachedVar('isWapVersion', false);
		
		$controllerName = DEFAULT_CONTROLLER;
	
		if (
			isset($_GET['area']) && ClassUtils::isClassName($_GET['area'])
			&& defined('PATH_CONTROLLERS')
			&& (
				is_readable(PATH_CONTROLLERS.'common'.DIRECTORY_SEPARATOR.$_GET['area'].EXT_CLASS)
				|| is_readable(PATH_CONTROLLERS.'web'.DIRECTORY_SEPARATOR.$_GET['area'].EXT_CLASS)
			)
		) {
			$controllerName = $_GET['area'];
		}
		
		$controller = new $controllerName;
		
		$modelAndView = $controller->handleRequest($request);
		
		$view 	= $modelAndView->getView();
		$model 	= $modelAndView->getModel();
		
		$prefix = PATH_WEB.'?area=';

		if (!$view)
			$view = $controllerName;
		elseif (is_string($view)) {
			if ($view == 'error')
				$view = new RedirectView($prefix);
			elseif (strpos($view, 'redirect:') !== false) {
				list(, $area) = explode(':', $view, 2);
				
				$view = new RedirectView(PATH_WEB.'?area='.$area);
			}
		}
		elseif ($view instanceof RedirectToView)
			$view->setPrefix($prefix);
		
		if (!$view instanceof View) {
			$viewName = $view;
			
			$viewResolver =
				MultiPrefixPhpViewResolver::create()->
				setViewClassName('SimplePhpView')->
				addPrefix(
					PATH_TEMPLATES.'common'.DIRECTORY_SEPARATOR
				)->
				addPrefix(
					PATH_TEMPLATES.'web'.DIRECTORY_SEPARATOR
				);
			
			$view = $viewResolver->resolveViewName($viewName);
		}
		
		if (!$view instanceof RedirectView) {
			$model->
				set('selfUrl', PATH_WEB.'?area='.$controllerName)->
				set('baseUrl', PATH_WEB)->
				set('controllerName', $controllerName);
		}
		
		$view->render($model);
	} catch (Exception $e) {
		
		$uri = $_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
		
		$msg =
			'class: '.get_class($e)."\n"
			.'code: '.$e->getCode()."\n"
			.'message: '.$e->getMessage()."\n\n"
			.$e->getTraceAsString()."\n"
			."\n_POST=".var_export($_POST, true)
			."\n_GET=".var_export($_GET, true)
			.(
				isset($_SERVER['HTTP_REFERER'])
					? "\nREFERER=".var_export($_SERVER['HTTP_REFERER'], true)
					: null
			)
			.(
				isset($_SESSION) ?
					"\n_SESSION=".var_export($_SESSION, true)
					: null
			);

		if (defined('__LOCAL_DEBUG__'))
			echo '<pre>'.$msg.'</pre>';
		else {
			mail(BUGLOVERS, $uri, $msg);
			DBPool::me()->shutdown();
			sleep(10);
			if (!HeaderUtils::redirectBack())
				HeaderUtils::redirectRaw('/');
		}
	}
?>