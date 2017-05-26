-- /* $Id$ */

-- book db

create sequence category_id;
create table category(
	id 		smallint not null default nextval('category_id') primary key,
	name	varchar(255) not null
);

--

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