
modISV.panel.Ticket = function (config) {
    config = config || {};

    Ext.apply(config, {
        border: false,
        id: 'modisv-ticketpanel',
        baseCls: 'modx-formpanel',
        width: 800,
        items: [{
            html: '<h2>Ticket</h2>',
            border: false,
            id: 'modisv-ticketpanel-header',
            cls: 'modx-page-header'
        },
        {
            html: '<div class="x-grid3" style="margin-bottom:40px;">\
                     <div class="x-grid3-viewport">\
                       <div class="x-grid3-header" style="margin:0 6px; font:bold 11px/28px arial; color:#EEE; text-shadow:0 1px 0 #363636;">MESSAGES</div>\
                       <div class="x-grid3-body" style="padding:20px 15px;"></div>\
                     </div>\
                   </div>',
            border: false,
            id: 'modisv-ticket-messages',
            tbar: [{
                text: 'Reply',
                handler: this.replyTicket,
                id: 'tb-reply-ticket',
                hidden: true,
                scope: this
            }, ' ',
            {
                text: 'Close',
                handler: this.closeTicket,
                id: 'tb-close-ticket',
                hidden: true,
                scope: this
            }, ' ',
            {
                text: 'Reopen',
                handler: this.reopenTicket,
                id: 'tb-reopen-ticket',
                hidden: true,
                scope: this
            }, ' ',
            {
                text: 'Add Watcher',
                handler: this.addWatcher,
                id: 'tb-add-watcher',
                hidden: true,
                scope: this
            }, '-',
            {
                text: 'Update',
                handler: this.updateTicket,
                id: 'tb-update-ticket',
                hidden: true,
                scope: this
            }]
        }]
    });

    modISV.panel.Ticket.superclass.constructor.call(this, config);

    this._refresh();
};

Ext.extend(modISV.panel.Ticket, MODx.Panel, {
    _refresh: function () {
        var mask = new Ext.LoadMask( Ext.get('modisv-ticket-messages'), {
            msg: "Loading"
        });
        mask.show();
        MODx.Ajax.request({
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/ticket/get',
                ticket: modISV.request.id
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        this.ticket = r.object['ticket'];
                        this.messages = r.object['messages'];

                        // update header text
                        var header = this.renderHeader();
                        Ext.getCmp('modisv-ticketpanel-header').getEl().update(header);

                        // show/hide tool buttons
                        if(this.ticket['status'] == 'open') {
                            Ext.getCmp('tb-reply-ticket').setVisible(true);
                            Ext.getCmp('tb-close-ticket').setVisible(true);
                            Ext.getCmp('tb-reopen-ticket').setVisible(false);
                            Ext.getCmp('tb-add-watcher').setVisible(true);
                            Ext.getCmp('tb-update-ticket').setVisible(true);
                        } else {
                            Ext.getCmp('tb-reply-ticket').setVisible(false);
                            Ext.getCmp('tb-close-ticket').setVisible(false);
                            Ext.getCmp('tb-reopen-ticket').setVisible(true);
                            Ext.getCmp('tb-add-watcher').setVisible(false);
                            Ext.getCmp('tb-update-ticket').setVisible(true);
                        }

                        // renders messages
                        var html = '';
                        for(var i=0; i<this.messages.length; i++)
                            html += this.renderMessage(i);
                        if(this.ticket.status == 'closed')
                            html += '<div class="modisv-ticket-activity">The ticket was closed on ' + this.ticket.closedon + '</div>';
                        Ext.select('#modisv-ticket-messages .x-grid3-body').update(html);
                        prettyPrint();  // prettify the code
                        mask.hide();
                    },
                    scope: this
                },
                'failure': {
                    fn: function (r) {
                        MODx.form.Handler.errorExt(r, this);
                        mask.hide();
                    },
                    scope: this
                }
            }
        });
    },
    renderHeader: function() {
        var tpl = Ext.DomHelper.createTemplate('\
            <h2 style="margin-bottom:0;">{subject}</h2>\
            <div style="margin-bottom:15px; font-size:10px; font-weight:bold; color:#666;">\
                <span>GUID: </span><u style="margin-right:20px;">{guid}</u>\
                <span>Status: </span><u style="margin-right:20px;">{status}</u>\
                <span>Topic: </span><u style="margin-right:20px;">{topic}</u>\
                <span>Priority: </span><u style="margin-right:20px;">{priority}</u>\
                <span>Product: </span><u style="margin-right:20px;">{product_name}</u>\
                <span>Target Version: </span><u style="margin-right:20px;">{target_version}</u>\
                <span>Due On: </span><u style="margin-right:20px;">{dueon}</u>\
            </div>');
        
        return tpl.apply(this.ticket);
    },
    renderMessage: function(index) {
        var tpl = Ext.DomHelper.createTemplate('\
            <div class="modisv-ticket-message">\
                <h5 class="header {cls}">\
                    <a name="{id}"></a>\
                    <a class="num" href="#{id}">{number}</a>\
                    <span class="info">{posted} by <b>{author}</b> on {date} via {source} ({ip})</span>\
                    <span class="actions">\
                        <a href="#" onclick="Ext.getCmp(\'modisv-ticketpanel\').updateMessage(\'{index}\');">Update</a>\
                        <a href="#" onclick="Ext.getCmp(\'modisv-ticketpanel\').removeMessage(\'{index}\');">Remove</a>\
                    </span>\
                </h5>\
                <img class="avatar" src="http://www.gravatar.com/avatar/{hash}?s=32&d=identicon" />\
                <div class="content wmd">\
                    {content}\
                    {attachments}\
                </div>\
            </div>');

        var message = this.messages[index];
        return tpl.apply({
            id: message.id,
            number: index + 1,
            index: index,
            date: message.createdon ? message.createdon.substring(0, 16) : '',
            hash: MD5((message.author_email || '').replace(/^\s+|\s+$/g, '').toLowerCase()),
            posted: index == 0 ? 'Created' : 'Posted',
            author: message.author_name ? (message.author_name + (message.author_email ? (' &lt;' + message.author_email + '&gt;') : '' )) : message.author_email,
            cls: message.staff_response ? 'staff-response' : '',
            source: message.source,
            ip: message.ip,
            content: message.html_body,
            attachments: this.renderAttachments(message.attachments)
        });
    },
    renderAttachments: function(attachments)  {
        if(!attachments || attachments.length == 0)
            return '';

        var tpl = Ext.DomHelper.createTemplate('\
            <div class="attachment">\
                <a class="name" href="{url}" title="Download">{name}</a>\
                <span class="size">{size}</span>\
                <a href="#" class="remove" onclick="Ext.getCmp(\'modisv-ticketpanel\').removeAttachment(\'{id}\');">Remove</a>\
            </div>');

        var attachments_html = '<div class="attachments">';
        for(var i=0; i<attachments.length; i++) {
            var a = attachments[i];
            attachments_html += tpl.apply({
                id: a.id,
                url: '?a=' + modISV.request.a + '&sa=download' + '&path=' + a.path.replace(/^\//, ""),
                name: a.name,
                size: (a.size / 1024).toFixed(1) + 'KB'
            });
        }
        attachments_html += '</div>';
        return attachments_html;
    },
    replyTicket: function() {
        MODx.load({
            xtype: 'modisv-window-reply-ticket',
            record: this.ticket,
            listeners: {
                'success': {
                    fn: function () {
                        this._refresh();
                    },
                    scope: this
                }
            }
        }).show();
    },
    closeTicket: function() {
        MODx.msg.confirm({
            title: 'Close Ticket',
            text: 'Are you sure you want to close this ticket?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/ticket/close',
                id: this.ticket.id,
                status: 'closed'
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        this._refresh();
                    },
                    scope: this
                }
            }
        });
        return true;
    },
    reopenTicket: function() {
        MODx.msg.confirm({
            title: 'Close Ticket',
            text: 'Are you sure you want to reopen this ticket?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/ticket/reopen',
                id: this.ticket.id,
                status: 'open'
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        this._refresh();
                    },
                    scope: this
                }
            }
        });
    },
    addWatcher: function() {
        MODx.load({
            xtype: 'modisv-window-add-watcher',
            record: this.ticket,
            listeners: {
                'success': {
                    fn: function() {
                        this._refresh();
                    },
                    scope: this
                }
            }
        }).show();
    },
    updateTicket: function() {
        MODx.load({
            xtype: 'modisv-window-update-ticket',
            record: this.ticket,
            listeners: {
                'success': {
                    fn: function() {
                        this._refresh();
                    },
                    scope: this
                }
            }
        }).show();
    },
    updateMessage: function(index) {
        MODx.load({
            xtype: 'modisv-window-message',
            record: this.messages[index],
            listeners: {
                'success': {
                    fn: function () {
                        this._refresh();
                    },
                    scope: this
                }
            }
        }).show();
    },
    removeMessage: function(index) {
        MODx.msg.confirm({
            title: 'Remove Message',
            text: 'Are you sure you want to remove this message?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/message/remove',
                id: this.messages[index].id
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        this._refresh();
                    },
                    scope: this
                }
            }
        });
        return true;
    },
    removeAttachment: function(id) {
        MODx.msg.confirm({
            title: 'Remove Attachment',
            text: 'Are you sure you want to remove this attachment?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/attachment/remove',
                id: id
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        this._refresh();
                    },
                    scope: this
                }
            }
        });
        return true;
    }
});
Ext.reg('modisv-panel-ticket', modISV.panel.Ticket);

