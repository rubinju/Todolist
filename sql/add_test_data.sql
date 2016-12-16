-- Person table testdata --
INSERT INTO Person (username, password) VALUES ('foo', 'bar');
INSERT INTO Person (username, password) VALUES ('spaceball', '1234');

-- Project table testdata --
INSERT INTO Project (name, person, taskcount) VALUES ('My summer car', 1, 1);
INSERT INTO Project (name, person, taskcount) VALUES ('Brewery', 1, 1);
INSERT INTO Project (name, person, taskcount) VALUES ('Building the DeathStar', 2, 1);


-- Priority table testdata --
INSERT INTO Priority (name) VALUES ('1');
INSERT INTO Priority (name) VALUES ('2');
INSERT INTO Priority (name) VALUES ('3');

-- Task table testdata --
INSERT INTO Task (description, created, status, person, priority, projectids) VALUES ('Buy beer', '2016-11-20', FALSE, 1, 2, '1');
INSERT INTO Task (description, created, status, person, priority, projectids) VALUES ('Create a new revolutionizing recipe', '2016-11-21', FALSE, 1, 3, '2');
INSERT INTO Task (description, created, status, person, priority, projectids) VALUES ('Spaceballs first task', '2016-12-07', TRUE, 2, 2, '3');


-- Projects testdata --
INSERT INTO Projects (task, project) VALUES (1, 1);
INSERT INTO Projects (task, project) VALUES (2, 2);
INSERT INTO Projects (task, project) VALUES (3, 3);
