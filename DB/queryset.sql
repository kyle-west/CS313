-- REVIEWS Info Merge
SELECT u.username AS "Owner", 
       d.filename AS "File Name", 
       r.status AS "Status", 
       (SELECT username FROM users WHERE id = r.reviewer) AS "Reviewer"
FROM users u INNER JOIN documents d
ON u.id = d.user_id
INNER JOIN reviews r 
ON d.id = r.doc_id
ORDER BY "Owner", "Status";

-- DOCUMENTS Info Merge (owned by, reviewed by)
SELECT d.filename AS "File",
       u.username AS "Owned By",
       (SELECT username FROM users WHERE id = r.reviewer) AS "Reviewed By",
       r.status   AS "Status"
FROM documents d FULL JOIN reviews r
ON d.id = r.doc_id
INNER JOIN users u 
ON u.id = d.user_id
ORDER BY r.status, d.filename;