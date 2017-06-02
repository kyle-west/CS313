-- Remove present data from the tables
TRUNCATE reviews, documents, users;


-- seed our tables with testable data
INSERT INTO users (username, password, ranking) VALUES
   ('test0','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',4), -- pass: 'password'
   ('test1','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',2), -- pass: 'password'
   ('test2','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',0), -- pass: 'password'
   ('test3','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',5), -- pass: 'password'
   ('test4','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',3), -- pass: 'password'
   ('test5','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',0), -- pass: 'password'
   ('test6','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',4), -- pass: 'password'
   ('test7','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',1), -- pass: 'password'
   ('test8','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',3), -- pass: 'password'
   ('test9','$2y$10$bxLQfD.RmX6U.Ai2axmmn.jOyoXRYa8IyG2ts.aI/FptD6yF/Gdle',0); -- pass: 'password'

INSERT INTO documents (user_id, filename, page_count) VALUES
   ((SELECT id FROM users WHERE username = 'test1'),'historypaper1',14),
   ((SELECT id FROM users WHERE username = 'test1'),'Physics Problem Set #4',3),
   ((SELECT id FROM users WHERE username = 'test1'),'New Testament Hwk',1),
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
    (SELECT id FROM users WHERE username = 'test1'), 1),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test7')
        AND  filename = 'Quantium Physics'),
    (SELECT id FROM users WHERE username = 'test9'), 1),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test0')
        AND  filename = 'qwgrtwrnhbfvsfbthg'),
    (SELECT id FROM users WHERE username = 'test7'), 3),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test5') 
        AND  filename = 'cpp_assignment'),
    (SELECT id FROM users WHERE username = 'test0'), 1),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test1') 
        AND  filename = 'englishpaper1'),
    (SELECT id FROM users WHERE username = 'test7'), 1),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test1') 
        AND  filename = 'historypaper1'),
    (SELECT id FROM users WHERE username = 'test9'), 2),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test1') 
        AND  filename = 'historypaper2'),
    (SELECT id FROM users WHERE username = 'test7'), 3),    
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test2') 
        AND  filename = 'whatev'),
    (SELECT id FROM users WHERE username = 'test7'), 2),
   ((SELECT id FROM documents 
        WHERE user_id = (SELECT id FROM users WHERE username = 'test2') 
        AND  filename = 'blahblah'),
    (SELECT id FROM users WHERE username = 'test1'), -9);
    
   
-- Validate  
SELECT * FROM users;
SELECT * FROM documents;
SELECT * FROM reviews;