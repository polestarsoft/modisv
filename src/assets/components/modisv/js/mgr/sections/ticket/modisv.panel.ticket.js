
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
                       <div class="x-grid3-header" style="margin:0 6px; font:bold 11px/28px arial; color:#EEE; text-shadow:0 1px 0 #363636;">THREADS</div>\
                       <div class="x-grid3-body" style="padding:20px 15px;"></div>\
                     </div>\
                   </div>',
            border: false,
            id: 'modisv-ticket-threads',
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

    this.loadThreads();
};

Ext.extend(modISV.Ticket, MODx.Panel, {
    loadThreads: function () {
        var mask = new Ext.LoadMask( Ext.get('modisv-ticket-threads'), {
            msg: "Loading"
        });
        mask.show();
        MODx.Ajax.request({
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/ticket/getthreads',
                ticket: modISV.request.id
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        var ticket = r.object['ticket'];
                        var threads = r.object['threads'];

                        // update header text
                        var header = '<h2>' + ticket['subject'] + ' [' + ticket['guid'] + ']</h2>';
                        Ext.getCmp('modisv-ticketpanel-header').getEl().update(header);

                        // show/hide tool buttons
                        if(ticket['status'] == 'open') {
                            Ext.getCmp('tb-reply-ticket').show();
                            Ext.getCmp('tb-close-ticket').show();
                            Ext.getCmp('tb-add-watcher').show();
                            Ext.getCmp('tb-update-ticket').show();
                        } else {
                            Ext.getCmp('tb-reopen-ticket').show();
                            Ext.getCmp('tb-update-ticket').show();
                        }

                        // renders threads
                        var html = '';
                        for(var i=0; i<threads.length; i++)
                            html += this.renderThread(threads, i);
                        Ext.select('#modisv-ticket-threads .x-grid3-body').update(html);
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
    renderThread: function(threads, index) {
        var tpl = Ext.DomHelper.createTemplate('<div style="padding:10px 0;">\
                     <h5 style="padding:6px; margin-bottom:15px; color:#FFF; background:{bg};  font:normal 10px arial; -moz-border-radius:3px; -webkit-border-radius:3px;">\
                       <a name="{id}"></a>\
                       <a style="margin-left:5px" href="#{id}">{number}</a>\
                       <span style="margin-left:10px">{posted} by <b>{author}</b> on {date} via {source} ({ip})</span>\
                       <span style="float:right;">\
                         <a style="margin-right:5px; color:#ccc;" href="#" onclick="Ext.getCmp(\'modisv-ticketpanel\').updateThread(\'{id}\');">Update</a>\
                         <a style="margin-right:5px; color:#ccc;" href="#" onclick="Ext.getCmp(\'modisv-ticketpanel\').removeThread(\'{id}\');">Remove</a>\
                       </span>\
                     </h5>\
                     <img style="float:left; margin-left:3px;" src="http://www.gravatar.com/avatar/{hash}?s=32&d=identicon" />\
                     <div style="margin-left:45px; padding-left:15px; border-left:1px solid #ddd;">\
                       <pre style="font:normal 12px Helvetica,Arial,sans-serif;">{content}</pre>\
                     </div>\
                   </div>');

        var thread = threads[index];
        return tpl.apply({
            id: thread.id,
            num: index + 1,
            date: thread.createdon.substring(0, 16),
            hash: MD5((thread.author_email || '').replace(/^\s+|\s+$/g, '').toLowerCase()),
            posted: index == 0 ? 'Created' : 'Posted',
            author: thread.author_name ? (thread.author_name + (thread.author_email ? (' &lt;' + thread.author_email + '&gt;') : '' )) : thread.author_email,
            bg: thread.response ? '#4C9ACF' : '#628F2C',
            source: thread.source,
            ip: thread.ip,
            content: Ext.util.Format.htmlEncode(thread.body) //TODO: fix me
        });
    },
    replyTicket: function() {
        //TODO:
    },
    closeTicket: function() {
        //TODO:
    },
    reopenTicket: function() {
        //TODO:
    },
    addWatcher: function() {
        //TODO:
    },
    updateTicket: function() {
        //TODO:
    },
    updateThread: function(id) {
        var xtype = id.startsWith('m') ? 'modisv-window-message' : 'modisv-window-response';
        MODx.load({
            xtype: xtype,
            update: true,
            listeners: {
                'success': {
                    fn: function () {
                        this.loadThreads();
                    },
                    scope: this
                }
            }
        }).show();
    },
    removeThread: function(id) {
        //TODO:
        alert('remove');
    }
});
Ext.reg('modisv-panel-ticket', modISV.Ticket);

