A new ticket has been received.

ID                      :[[+ticket.id]]
Subject                 :[[+ticket.subject]]
Topic                   :[[+ticket.topic]]
Author                  :[[+message.author_name:is=``:then=`[[+message.author_email]]`:else=`[[+message.author_name]] <[[+message.author_email]]>` ]]
Created On              :[[+ticket.createdon]]
Source                  :[[+ticket.source]] ([[+ticket.ip]])
URL                     :[[+ticket.url]]

----------------------------------------
[[+message.body]]