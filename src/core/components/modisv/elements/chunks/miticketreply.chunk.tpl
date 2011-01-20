[[++modisv.ticket_reply_separator]]
From: [[+message.author_name:is=``:then=`[[+message.author_email]]`:else=`[[+message.author_name]] <[[+message.author_email]]>` ]]
Subject: [[+ticket.subject]]

[[+message.body]]

[[+message.attachments:is=``:then=``:else=`
Attachments for this ticket:
[[+message.attachments]]
`]]

View this ticket at site online: [[+ticket.url]]
