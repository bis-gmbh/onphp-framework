# Первый публичный пример приложения на onPHP. onPHP in action.

## I. onPHP - что это?

Это зрелый объектно-ориентированный framework для разработки web-приложений на php.

Кратко и тезисно перечислю основные достоинства onPHP, не вдаваясь в детали.

1. Быстрая разработка приложений.
2. Горизонтальная масштабируемость приложений.
3. Чрезвычайная гибкость. Настраивается все, начиная от того, с какой СУБД работать и заканчивая стратегиями выборки данных и их кэширования.

### 1. Быстрая разработка приложений.

Здесь на сцену выходит прежде всего Meta. Это не что иное,
как самая настоящая кодогенерация. Пример использования будет ниже.
Criteria для выборки данных, готовые базовые классы для написания различных контроллеров,
которые работают с вводимыми пользователем данными, так называемые EditorController. Примеры будут ниже.
Формально это ближе всего к MVC 2.
Также имеется множество утилитных классов, которые могут использоваться совершенно независимо.
Чего стоит только один HtmlTokenizer, который понимает абсолютно невалидные документы html.

### 2. Горизонтальная масштабируемость приложений.

Не буду говорить о масштабируемости web-приложений вообще, так как это отдельная большая тема.
Скажу только о том, что дает нам onPHP.
Прозрачное кэширование, которое может быть распределено между разными пирами (файловая система, сервера memcached и т.д.).
Множество источников данных в пределах одного приложения.
Пул источников данных (соединения с базой данных).
Можно указать, что вот это dao ходит в mysql, а вот это в postgres и т.д.
И когда вам нужно будет "размазать" приложение по нескольким серверам, вам НЕ ПРИДЕТСЯ ЕГО ПЕРЕПИСЫВАТЬ.

### 3. Гибкость.

Да. Это очень гибкий framework. Описывать все возможность долго, нудно и неинтересно.
Лучше просто попробовать. А если сами не смогли найти решение, то всегда можно спросить в рассылке или на канале irc.
Есть небольшие проекты, которые работают на shared hosting за 300 рублей в месяц (бд mysql/сборка php - cgi).
А есть проекты, которые работают на нескольких серверах, имеют десятки миллионов хитов в сутки,
И снова вам НЕ ПРИДЕТСЯ ЕГО ПЕРЕПИСЫВАТЬ при переезде. Меняйте конфигурационный файл и настраивайте nginx/os :-)
"Маленькое приложение" будет также надежно, как и огромный проект.

## II. Приложение.

В качестве тестового приложения предлагается некоторая абстрактная гостевая книга.
Работа будет доступна в двух режимах. Пользовательский и администраторский.

Пользователи могут:

a. Добавлять сообщения.
b. Просматривать сообщения.

Администраторы могут:

a. Добавлять и изменять записи.
b. Просматривать сообщения.

..

### 1. Структура проекта.

Любое приложение в onPHP начинается с проекта, который, как правило,
имеет типовую структуру расположения каталогов.

```
/book
	 /db/
	 /meta
	 /misc
	 /src
		 /classes
		 /controllers
		 /htdocs
		 /templates
```

- `book` - корневая директория проекта.
- `book/db` - схема данных на языке sql (мы стараемся использовать только ANSISQL).
- `book/misc` - разное, то, что не вошло никуда.
- `book/meta` - конфигурационный файл для генератора кода (meta).
- `book/src` - исходный код проекта.
- `book/src/htdocs` - аналог frontcontroller в нотации mvc (скоро будет заменен пакетом Application).
- `book/src/templates` - шаблоны.

### 2. Метаконфигурация и основные классы.

Метаконфигурация - это прежде всего xml-файл. У него есть структура, описанная в meta.dtd.
Синтаксис файла мета-конфигурации чрезвычайно прост и интуитивно понятен.

Определим основные объекты системы. Это "сообщение" и "категория сообщения". Между ними есть связь.
В каждой категории может быть несколько сообщений, но каждое сообщение может иметь только одну категорию.

Напишем мету, исходя из вышеизложенных рассуждений.

```xml
<?xml version="1.0"?>
<!DOCTYPE metaconfiguration SYSTEM "meta.dtd">

<metaconfiguration>
	<classes>

	<!-- Основное описание классов, которые должны быть сгенерированы, находится здесь.-->

	<class name="Message" type="final">
	<properties>
		<identifier type="Integer" />
		<property name="name" type="String" size="255" required="true" />
		<property name="text" type="String" size="2048" required="true" />
		<property name="category" type="Category" relation="OneToOne" required="true" />
		<property name="author" type="String" size="20" required="false" />

		<property name="created" type="Timestamp" required="true" />
	</properties>
	<pattern name="DictionaryClass" />
	</class>

	<class name="Category" type="final">
	<properties>
		<identifier type="SmallInteger" />
		<property name="name" type="String" size="255" required="true" />

		<!-- Коллекция сообщений для категории -->
		<property name="messages" relation="OneToMany" type="Message" required="false" />
	</properties>
	<pattern name="DictionaryClass" />
	</class>

	</classes>
</metaconfiguration>
```

Чтобы сгенерировать классы воспользуемся metabuilder:

```
sherman@black-mamba /var/www/book.oem.boo/book $ php ~/work/php/onphp/branches/0.10/meta/bin/build.php

Trying to guess path to project's configuration file: src/config.inc.php.
Trying to guess path to MetaConfiguration file: meta/config.xml.

onPHP-0.10.4.99: MetaConfiguration builder.

...
```

Мета как правило генерирует на каждый тип объекта (за исключением Enumeration/Dto/Spooked) несколько файлов.
Классы которые создаются с приставкой auto никогда не должны модифицироваться в ручную,
meta перестраивает их самостоятельно. Для расширения используйте наследников auto-классов.

После успешного окончания процесса генерации у вас появятся следующие файлы:

DAO классы. Классы доступа к данных.
Все что относится к данным, в том числе OSQL-запросы, транзакции, названия таблиц, атрибутов и т.д. все здесь.

```
classes/Auto/DAOs/AutoMessageDAO.class.php
classes/Auto/DAOs/AutoCategoryDAO.class.php
classes/DAOs/MessageDAO.class.php
classes/DAOs/CategoryDAO.class.php
classes/DAOs/CategoryMessagesDAO.class.php
```

Классы proto. Различная метаинформация о данных.
Форма (используется при модификации экзепляров объектов в EditorController).

```
classes/Auto/Proto/AutoProtoCategory.class.php
classes/Auto/Proto/AutoProtoMessage.class.php
classes/Proto/ProtoCategory.class.php
classes/Proto/ProtoMessage.class.php
```

Business классы. Бизнес логика.
Бизнес сущности, типы объектов, которыми оперирует система.

```
classes/Auto/Business/AutoMessage.class.php
classes/Auto/Business/AutoCategory.class.php
classes/Business/Message.class.php
classes/Business/Category.class.php
```

Физическая схема данных на языке OSQL.

```
classes/Auto/schema.php
```

### 3. Физическая схема данных.

Теперь настало время подумать о физическом споосбе хранения данных.
Для большинства приложний это СУБД.
Я предпочитаю PostgreSQL, также поддерживается Mysql/Sqlite.

Таблица "Категория".

```sql
create sequence category_id;
create table category(
	id 		smallint not null default nextval('category_id') primary key,
	name	varchar(255) not null
);
```

Таблица "Сообщение".

```sql
create sequence message_id;
create table message(
	id 			integer not null default nextval('message_id') primary key,
	name		varchar(255) not null, -- aka title
	text		varchar(2048) not null,
	category_id	smallint not null references category(id) on delete cascade on update cascade,
	author		varchar(20) null,
	created		timestamp not null
);

create index message_category_idx on message(category_id);
```

Как мы видим, в простом случае физическая схема данных очень похожа на meta-конфигурацию.
Различия начинаются при более сложных отношениях или при использовании одного из паттернов
моделирования структур связанных наследованием в реляционных СУБД (смотри Фаулера).

### 4. Бизнес логика приложения.

То, ради чего мы и затевали разработку данного приложения.
Как я уже говорил ближе всего это к модели MVC 2. Есть контроллеры, есть модель,
через которую данных попадают в представление.
Роль frontController-а и маршрутиризатора запросов выполняет простой index.php (смотрите исходный код).
В скором времени, ему на смену придет пакет Application.

Подробнее остановимся на контроллерах.

### 4.1. Добавление записи в книгу.

Операция абсолютно одинакова для админа и для обычного пользователя.
Поэтому во избежании дублирования кода сделаем общего абстрактного наследника,
в котором инкапсулируем всю общую бизнес логику.
Сама логика добавления записи будет в отдельном классе MessageAddCommand.
Здесь же будет импорт и валидация данных пришедших из post/get.
И для этого не придеться писать вообще ничего (помните proto ?:-))
MessageAddCommand будет абсолютно одинаковым для админа и пользователя.

Содержание класса baseEditMessage:

```php
abstract class baseEditMessage extends EditorController
{
	public function __construct()
	{
		parent::__construct(Message::create());

		$this->commandMap['add'] 	= new MessageAddCommand();
		$this->commandMap['save'] 	= new MessageSaveCommand();
	}

	public function handleRequest(HttpRequest $request)
	{
		$mav = parent::handleRequest($request);

		// get available category list
		$mav->getModel()->set(
		'categories',
		Criteria::create(Category::dao())->
		getList()
		);

		return $mav;
	}
}
```

Содержание класса MessageAddCommand:

```php
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
```

Как видно из кода, я чуть расширил стандартные классы из onPHP,
которые и сделают все реальную работу за меня.

Финальный админский контроллер выглядит так:

Содержание класса editMessage (админ):

```php
final class editMessage extends baseEditMessage {/*_*/}
```

Круто ?

В принципе, финальный пользовательский контроллер мог бы выглядеть также,
но я параноик, поэтому ограничу жестко перечень операций,
которые может совершить пользователь всего одной, а именно добавлением:

Содержание класса editMessage (пользователь):

```php
final class editMessage extends baseEditMessage
{
	public function	handleRequest(HttpRequest $request)
	{
		// a bit of paranoia
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
```

Хмм. Несколько десятков строчек кода и наше приложение
уже умеет работать с сообщениями, причем в двух режимах.

А где же html-форма? Давайте взглянем на шаблоны.
Html-форма для пользователя и админа будет опять же абсолютно одинаковой.

Фрагмент:

```php
<form
	action="<?=$selfUrl?>&<?=
	$form->getValue('id')
		? 'action=save&id='.$form->getValue('id')->getId()
		: 'action=add'
	?>"
	method="POST"
>
<table>
	<tr>
	<td><b>Заголовок *</b></td>
	<td>
<input
	type="text"
	name="name"
	value="<?=htmlspecialchars($form->getValue('name'))?>"
/>
<?php
	if ($error = $form->getTextualErrorFor('name')) {
?>
	<span style="color: #f00"><?=$error?></span>
<?php
	}
?>
	</td>
	</tr>
	<tr>
	<td><b>Автор *</b></td>
	<td>
<input
	type="text"
	name="author"
	value="<?=htmlspecialchars($form->getValue('author'))?>"
/>
<?php
	if ($error = $form->getTextualErrorFor('author')) {
?>
	<span style="color: #f00"><?=$error?></span>
<?php
	}
?>
```

### 4.2. Вывести список сообщений.

А вывод сообщений ? Нет ничего проще:

```php
final class messageList implements Controller
{
	public function handleRequest(HttpRequest $request)
	{
		$criteria =
		Criteria::create(Message::dao())->
		addOrder(
			OrderBy::create('created')->
			desc()
		)->
		getList();

		return
		ModelAndView::create()->
		setModel(
			Model::create()->
			set('messages', $messages)
		);
	}
}
```

Шаблон для вывода:

```php
<?php
	$partViewer->view('parts/head');

	foreach ($messages as $message) {
?>
	<b><?=$message->getName()?></b></br>
	<?=$message->getText()?></br>
<?php
	}
?>

<?php
	$partViewer->view('parts/foot');
?>
```

Полную версию исходного кода можно найти [тут](http://web.archive.org/web/20120303153349/http://mobileon.ru/patches/book.src.tgz).

## III. Подводя итоги.

К сожалению, за кадром остались очень многие интересные темы. Например, цепочки фильтров и их применение,
механизм кэша и различные стратегии кэширования, OSQL и многое другое, без чего бы не получился этот framework.
Но с другой стороны, должно же быть что-то, что вы должны узнать самостоятельно :-)

2007 год.

Ссылка на оригинал статьи: http://gabaidulin.livejournal.com/64485.html
