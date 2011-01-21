
modISV.grid.Tickets = function (config) {
    config = config || {};

    this.sm = new Ext.grid.CheckboxSelectionModel();
    Ext.applyIf(config, {
        id: 'modisv-grid-tickets',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/ticket/getlist'
        },
        fields: ['id', 'priority', 'topic', 'product', 'product_name', 'author_name', 'author_email', 'author_id', 'watchers', 'subject', 'note', 'target_version', 'status', 'source', 'ip', 'overdue', 'answered', 'dueon', 'reopenedon', 'closedon', 'lastmessageon', 'lastresponseon', 'createdon', 'updatedon', 'message_count', 'menu'],
        sm: this.sm,
        columns: [this.sm, {
            header: 'ID',
            dataIndex: 'id',
            renderer: renderTicketLink,
            sortable: true,
            width: 30
        },
        {
            header: 'Topic',
            dataIndex: 'topic',
            sortable: true,
            width: 30
        },
        {
            header: 'Subject',
            dataIndex: 'subject',
            sortable: true,
            width: 180
        },
        {
            header: 'Status',
            dataIndex: 'status',
            renderer: renderTicketStatus,
            sortable: true,
            width: 40
        },
        {
            header: 'Replies',
            dataIndex: 'message_count',
            sortable: true,
            width: 40
        },
        {
            header: 'Answered',
            dataIndex: 'answered',
            renderer: renderTicketAnswered,
            sortable: true,
            width: 40
        },
        {
            header: 'Overdue',
            dataIndex: 'overdue',
            renderer: renderTicketOverdue,
            sortable: true,
            width: 40
        },
        {
            header: 'Priority',
            dataIndex: 'priority',
            renderer: renderTicketPriority,
            sortable: true,
            width: 40
        },
        {
            header: 'Author',
            dataIndex: 'author_email',
            renderer: renderTicketAuthor,
            sortable: true,
            width: 80
        },
        {
            header: 'Watchers',
            dataIndex: 'watchers',
            renderer: renderTicketWatchers,
            sortable: true,
            width: 40
        },
        {
            header: 'Product',
            dataIndex: 'product',
            renderer: renderProduct,
            sortable: true,
            width: 40
        },
        {
            header: 'Target Version',
            dataIndex: 'target_version',
            renderer: renderTicketMilestone,
            sortable: true,
            width: 50
        },
        {
            header: 'Source',
            dataIndex: 'source',
            renderer: renderTicketSource,
            sortable: true,
            width: 40
        },
        {
            header: 'Misc',
            dataIndex: 'id',
            renderer: renderTicketMiscInfo,
            width: 30
        }]
    });
    modISV.grid.Tickets.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Tickets, modISV.Grid, {
    updateTicket: function (btn, e) {
        if (this.menu.record && this.menu.record.id) {
            MODx.load({
                xtype: 'modisv-window-update-ticket',
                record: this.menu.record,
                listeners: {
                    'success': {
                        fn: function() {
                            this.refresh();
                        },
                        scope: this
                    }
                }
            }).show();
        }
    },
    viewTicket: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=ticket&id=' + this.menu.record.id;
    },
    removeTicket: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Ticket',
            text: 'Are you sure you want to remove this ticket?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/ticket/remove',
                id: this.menu.record.id
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
        return true;
    }
});
Ext.reg('modisv-grid-tickets', modISV.grid.Tickets);
