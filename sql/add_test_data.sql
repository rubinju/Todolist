-- Person table testdata --
INSERT INTO Person (username, password) VALUES ('foo', 'bar');
INSERT INTO Person (username, password) VALUES ('spaceball', '1234');

-- Project table testdata --
INSERT INTO Project (name) VALUES ('My summer car');
INSERT INTO Project (name) VALUES ('Brewery');

-- Priority table testdata --
INSERT INTO Priority (name) VALUES ('0');
INSERT INTO Priority (name) VALUES ('1');
INSERT INTO Priority (name) VALUES ('2');
INSERT INTO Priority (name) VALUES ('3');

-- Task table testdata --
INSERT INTO Task (description, created, status) VALUES ('Buy beer', '2016-11-20', 'false');