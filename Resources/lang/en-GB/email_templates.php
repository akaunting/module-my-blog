<?php

return [

    'comment_new_author' => [
        'subject'   => 'New comment on {post_name}',
        'body'      => 'Dear {post_author},<br /><br />You have a new comment from {comment_author}:<br /><br />{comment_description}<br /><br />Best Regards,<br />{company_name}',
    ],

    'comment_delete_author' => [
        'subject'   => 'Comment of {post_name} has been deleted',
        'body'      => 'Dear {post_author},<br /><br />The following comment from {comment_author} has been deleted:<br /><br />{comment_description}<br /><br />Best Regards,<br />{company_name}',
    ],

];
