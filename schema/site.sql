create database if not exists ActionPHP;
use ActionPHP;

create table if not exists role(
	id int unsigned not null auto_increment primary key,
	name varchar(30) not null unique
);

create table if not exists file(
	id int unsigned not null auto_increment primary key,
	filename varchar(255) not null,
	mime varchar(255) not null,
	path varchar(255) not null,
	size int unsigned not null
);


create table if not exists user(
	id int unsigned not null auto_increment primary key,
	username varchar(40) not null,
	email varchar(255) not null unique,
	password varchar(60) not null,
	role varchar(30) references role(name),
	avatar int references file(id)
);

insert into role(name) values
	('admin'),
	('user');

insert into user set
	username = 'admin',
	email = 'admin@test.xyz',
	password = '$2a$12$kj3KOoRbikek6Sb3s24T4.imUwRFnVDUrUqtwCYMtwbWwtOcb.x1a',
	role = 'admin';
