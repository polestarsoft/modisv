
modISV.Ticket = function (config) {
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

    modISV.Ticket.superclass.constructor.call(this, config);

    this.loadTicket();
};

Ext.extend(modISV.Ticket, MODx.Panel, {
    loadTicket: function () {
        var mask = new Ext.LoadMask( Ext.get('modisv-ticket-messages'), {
            msg: "Loading"
        });
        mask.show();
        MODx.Ajax.request({
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/ticket/getmessages',
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
                        Ext.select('#modisv-ticket-messages .x-grid3-body').update(html);
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
            <div style="padding:10px 0;">\
                <h5 style="padding:6px; margin-bottom:15px; color:#FFF; background:{bg};  font:normal 10px arial; -moz-border-radius:3px; -webkit-border-radius:3px;">\
                    <a name="{id}"></a>\
                    <a style="margin-left:5px" href="#{id}">{number}</a>\
                    <span style="margin-left:10px">{posted} by <b>{author}</b> on {date} via {source} ({ip})</span>\
                    <span style="float:right;">\
                        <a style="margin-right:5px; color:#ccc;" href="#" onclick="Ext.getCmp(\'modisv-ticketpanel\').updateMessage(\'{index}\');">Update</a>\
                        <a style="margin-right:5px; color:#ccc;" href="#" onclick="Ext.getCmp(\'modisv-ticketpanel\').removeMessage(\'{index}\');">Remove</a>\
                    </span>\
                </h5>\
                <img style="float:left; margin-left:3px;" src="http://www.gravatar.com/avatar/{hash}?s=32&d=identicon" />\
                <div style="margin-left:45px; padding-left:15px; border-left:1px solid #ddd;">\
                    <pre style="font:normal 12px Helvetica,Arial,sans-serif;">{content}</pre>\
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
            bg: message.staff_response ? '#4C9ACF' : '#628F2C',
            source: message.source,
            ip: message.ip,
            content: Ext.util.Format.htmlEncode(message.body) //TODO: fix me
        });
    },
    replyTicket: function() {
        MODx.load({
            xtype: 'modisv-window-reply-ticket',
            record: this.ticket,
            listeners: {
                'success': {
                    fn: function () {
                        this.loadTicket();
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
                        this.loadTicket();
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
                        this.loadTicket();
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
                        this.loadTicket();
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
                        this.loadTicket();
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
                        this.loadTicket();
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
                        this.loadTicket();
                    },
                    scope: this
                }
            }
        });
        return true;
    }
});
Ext.reg('modisv-panel-ticket', modISV.Ticket);

