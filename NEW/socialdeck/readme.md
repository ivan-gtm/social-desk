** scrapper_accounts
id
created_at
updated_at
type ( username, board )
origin_id (fb, insta, pinte)
username
status bool

** scrapper_tasks
id
scheduled_at
finished_at
account_id
is_recurrent
status ( created, scheduled, executed, error )
interval ( 3 )
unit ( minutes )
type ( username, board )
origin_id (fb, insta, pinte)



** scrapper_posts
id
task_id
account_id
uid
url
data json
post_id
