A new message has been received.

Ticket GUID             :[[+ticket.guid]]
Ticket Subject          :[[+ticket.subject]]
Ticket Topic            :[[+ticket.topic]]
Ticket Created On       :[[+ticket.createdon]]
Author                  :[[+message.author_name:is=``:then=`[[+message.author_email]]`:else=`[[+message.author_name]] <[[+message.author_email]]>` ]]
Source                  :[[+message.source]] ([[+message.ip]])
URL                     :[[+ticket.url]]

----------------------------------------
[[+message.body]]