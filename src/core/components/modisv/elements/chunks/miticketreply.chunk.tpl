[[++modisv.ticket_reply_separator]]
From: [[+message.author_name]]
Subject: [[+ticket.subject]]

[[+message.body]]

[[!If? &subject=`[[+message.attachments]]` &operator=`isnotempty` &then=`
Attachments for this ticket:
[[+message.attachments]]
`]]

View this ticket at site online: [[+ticket.url]]
