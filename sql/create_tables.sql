CREATE TABLE Task(
	id SERIAL PRIMARY KEY,
	description varchar(255) NOT NULL,
	created DATE,
	status boolean DEFAULT FALSE,
	user INTEGER REFERENCES User(id),
	priority INTEGER REFERENCES Priority(id)
);

CREATE TABLE User(
	id SERIAL PRIMARY KEY, 
	username varchar(50) NOT NULL,
	password varchar(50) NOT NULL
);

CREATE TABLE Projects( -- TODO: check if it goes like this
	Task INTEGER REFERENCES Task(id),
	Project INTEGER REFERENCES Project(id)
);

CREATE TABLE Project(
	id SERIAL PRIMARY KEY,
	name varchar(255) NOT NULL,
	user INTEGER REFERENCES User(id)
);

CREATE TABLE Priority(
	id SERIAL PRIMARY KEY,
	name smallint NOT NULL
);