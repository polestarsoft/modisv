A new message has been received.

Ticket GUID             :[[+ticket.guid]]
Ticket Subject          :[[+ticket.subject]]
Ticket Product          :[[+ticket.product]]
Ticket Topic            :[[+ticket.topic]]
Ticket Created On       :[[+ticket.createdon]]
Author                  :[[!If? &subject=`[[+message.author_name]]` &operator=`isnotempty` &then=`[[+message.author_name]] <[[+message.author_email]]>` &else=`[[+message.author_email]]` ]]
Source                  :[[+message.source]] ([[+message.ip]])
URL                     :[[+ticket.url]]

----------------------------------------
[[+message.body]]