
CREATE TABLE Person(
	id SERIAL PRIMARY KEY, 
	username varchar(50) NOT NULL,
	password varchar(50) NOT NULL
);

CREATE TABLE Project(
	id SERIAL PRIMARY KEY,
	name varchar(255) NOT NULL,
	person INTEGER REFERENCES Person(id),
	taskcount SMALLINT -- Number of tasks in the project
);

CREATE TABLE Priority(
	id SERIAL PRIMARY KEY,
	name smallint NOT NULL
);

CREATE TABLE Task(
	id SERIAL PRIMARY KEY,
	description varchar(255) NOT NULL,
	created DATE,
	status boolean DEFAULT FALSE,
	person INTEGER REFERENCES Person(id),
	priority INTEGER REFERENCES Priority(id),
	projectids varhar(30) -- For visualizing which projects this is part of
);

CREATE TABLE Projects( -- Could have a better name, many-to-many
	task INTEGER REFERENCES Task(id),
	project INTEGER REFERENCES Project(id)
);