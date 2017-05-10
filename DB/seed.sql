-- Remove present data from the tables
TRUNCATE reviews, documents, users;


-- seed our tables with testable data
INSERT INTO users (username, password) VALUES
   ('admin','21232f297a57a5a743894a0e4a801fc3'), -- pass: 'admin'
   ('test0','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test1','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test2','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test3','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test4','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test5','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test6','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test7','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test8','5f4dcc3b5aa765d61d8327deb882cf99'), -- pass: 'password'
   ('test9','5f4dcc3b5aa765d61d8327deb882cf99'); -- pass: 'password'

INSERT INTO documents (user_id, filename, page_count) VALUES
   ((SELECT id FROM users WHERE username = 'test1'),'historypaper1',14),
   ((SELECT id FROM users WHERE username = 'test3'),'a3',42),
   ((SELECT id FROM users WHERE username = 'test2'),'whatev',4),
   ((SELECT id FROM users WHERE username = 'test6'),'abcd',5),
   ((SELECT id FROM users WHERE username = 'test3'),'a2',9),
   ((SELECT id FROM users WHERE username = 'test5'),'cpp_assignment',5),
   ((SELECT id FROM users WHERE username = 'test5'),'java_debug',7),
   ((SELECT id FROM users WHERE username = 'test1'),'historypaper2',4),
   ((SELECT id FROM users WHERE username = 'test1'),'englishpaper1',6),
   ((SELECT id FROM users WHERE username = 'test7'),'The Hippo Effect',3),
   ((SELECT id FROM users WHERE username = 'test4'),'adventure',81),
   ((SELECT id FROM users WHERE username = 'test3'),'a2',3),
   ((SELECT id FROM users WHERE username = 'test7'),'Engineering 101',7),
   ((SELECT id FROM users WHERE username = 'test0'),'qwgrtwrnhbfvsfbthg',4),
   ((SELECT id FROM users WHERE username = 'test8'),'newfile1',7),
   ((SELECT id FROM users WHERE username = 'test9'),'i like hotsauce',4),
   ((SELECT id FROM users WHERE username = 'test2'),'blahblah',6),
   ((SELECT id FROM users WHERE username = 'test3'),'a1',4),
   ((SELECT id FROM users WHERE username = 'test7'),'Quantium Physics',8),
   ((SELECT id FROM users WHERE username = 'test0'),'jnqeafkmglkqm',1);

INSERT INTO reviews (doc_id, reviewer, status) VALUES
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test7')
        AND  filename = 'Quantium Physics'),
    (SELECT id FROM users WHERE username = 'test5'), 1),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test7')
        AND  filename = 'Quantium Physics'),
    (SELECT id FROM users WHERE username = 'test8'), 1),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test0')
        AND  filename = 'qwgrtwrnhbfvsfbthg'),
    (SELECT id FROM users WHERE username = 'test7'), 3),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test5') 
        AND  filename = 'cpp_assignment'),
    (SELECT id FROM users WHERE username = 'test0'), 1),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test2') 
        AND  filename = 'whatev'),
    (SELECT id FROM users WHERE username = 'test7'), 0),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test2') 
        AND  filename = 'blahblah'),
    (SELECT id FROM users WHERE username = 'test1'), 0);
    
   
-- Validate  
SELECT * FROM users;
SELECT * FROM documents;
SELECT * FROM reviews;