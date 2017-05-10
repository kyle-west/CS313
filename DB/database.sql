-- Drop tables with respect to dependencies
DROP TABLE IF EXISTS reviews;    -- #3 | FK on #1 & #2 tables
DROP TABLE IF EXISTS documents;  -- #2 | FK on #1 table
DROP TABLE IF EXISTS users;      -- #1 | No dependencies


-- Create the tables in order to establish dependencies
CREATE TABLE users (
   id         SERIAL      PRIMARY KEY NOT NULL,
   username   VARCHAR(50) UNIQUE      NOT NULL,
   password   CHAR(32)                NOT NULL, -- PHP MD5 hashes to 32 chars (128 bit)
   ranking    INTEGER     DEFAULT 0   NOT NULL  -- Rank from 0 to 5 stars
);

CREATE TABLE documents (
   id         SERIAL  PRIMARY KEY                      NOT NULL,
   user_id    INTEGER REFERENCES users(id)             NOT NULL,
   filename   VARCHAR(255)                             NOT NULL,
   page_count INTEGER DEFAULT 1 CHECK (page_count > 0) NOT NULL 
);

CREATE TABLE reviews (
   id         SERIAL  PRIMARY KEY              NOT NULL,
   doc_id     INTEGER REFERENCES documents(id) NOT NULL,
   reviewer   INTEGER REFERENCES users(id)     NOT NULL,
   status     INTEGER DEFAULT 0                NOT NULL  -- Codes to delimit status 
);


-- Validate we set everything up correctly
\d+ users;
\d+ documents;
\d+ reviews;