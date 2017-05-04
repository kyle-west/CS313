-- drop dependancies
DROP TABLE IF EXISTS test2;

-- Configure the test table
DROP TABLE IF EXISTS test;

CREATE TABLE test (
       id  SERIAL PRIMARY KEY NOT NULL,
       dat VARCHAR(30) NOT NULL
);

-- Seed the test table
INSERT INTO test (dat) VALUES
       ('item one'),
       ('item two'),
       ('item three'),
       ('item four'),
       ('item five');

-- validate our data seeding
SELECT * FROM test;


-- create another table linked to test by FK
CREATE TABLE test2 (
       id SERIAL PRIMARY KEY NOT NULL,
       test_id INTEGER REFERENCES test(id) NOT NULL,
       dat VARCHAR(30) NOT NULL
);

-- seed our test1 table
INSERT INTO test2 (test_id, dat) VALUES
       (4,'connect 4'),
       ((SELECT id FROM test WHERE dat LIKE '%two'  LIMIT 1),'connect 2');

-- validate this is a correct linking
SELECT * FROM test2;

SELECT two.id, two.dat, one.dat
FROM test one JOIN test2 two
ON two.test_id = one.id;
