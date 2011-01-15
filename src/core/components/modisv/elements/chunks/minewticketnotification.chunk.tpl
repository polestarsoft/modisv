A new ticket has been received.

GUID                    :[[+ticket.guid]]
Subject                 :[[+ticket.subject]]
Product                 :[[+ticket.product]]
Topic                   :[[+ticket.topic]]
Author                  :[[!If? &subject=`[[+ticket.author_name]]` &operator=`isnotempty` &then=`[[+ticket.author_name]] <[[+ticket.author_email]]>` &else=`[[+ticket.author_email]]` ]]
Created On              :[[+ticket.createdon]]
Source                  :[[+ticket.source]] ([[+ticket.ip]])
URL                     :[[+ticket.url]]

----------------------------------------
[[+message.body]]