create database if not exists test;
use test;

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
	role varchar(30) default null references role(name)
		on update cascade 
		on delete set null,
	avatar int unsigned references file(id) 
		on delete set null,
	banned boolean not null default false,
	creation datetime not null default current_timestamp
);


delimiter &&
if not(select count(1) from user where id = 1) then
	insert into role(name) values
		('admin'),
		('user');
	insert into user set
		username = 'admin',
		email = 'admin@test.xyz',
		password = '$2a$12$kj3KOoRbikek6Sb3s24T4.imUwRFnVDUrUqtwCYMtwbWwtOcb.x1a',
		role = 'admin';
end if&&
delimiter ;
