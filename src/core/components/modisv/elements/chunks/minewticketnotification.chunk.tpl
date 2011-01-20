[[++modisv.ticket_reply_separator]]
Topic: [[+ticket.topic:ucfirst]]
Source: [[+ticket.source:ucfirst]] ([[+ticket.ip]])
From: [[+message.author_name:is=``:then=`[[+message.author_email]]`:else=`[[+message.author_name]] <[[+message.author_email]]>` ]]
Subject: [[+ticket.subject]]

[[+message.body]]

[[+message.attachments:is=``:then=``:else=`
Attachments for this ticket:
[[+message.attachments]]
`]]
View this ticket online:
Backend: [[+ticket.backend_url]]
Frontend: [[+ticket.url]]
