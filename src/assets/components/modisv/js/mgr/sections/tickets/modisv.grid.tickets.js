
modISV.grid.Tickets = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-tickets',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/ticket/getlist'
        },
        fields: ['id', 'guid', 'priority', 'topic', 'product', 'product_name', 'author_name', 'author_email', 'author_id', 'watchers', 'subject', 'note', 'target_version', 'status', 'source', 'ip', 'overdue', 'answered', 'dueon', 'reopenedon', 'closedon', 'lastmessageon', 'lastresponseon', 'createdon', 'updatedon', 'menu'],
        columns: [{
            header: 'ID',
            dataIndex: 'id',
            sortable: true,
            width: 30
        },
        {
            header: 'GUID',
            dataIndex: 'guid',
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
            width: 200
        },
        {
            header: 'Status',
            dataIndex: 'status',
            renderer: renderTicketStatus,
            sortable: true,
            width: 30
        },
        {
            header: 'Answered',
            dataIndex: 'answered',
            renderer: renderTicketAnswered,
            sortable: true,
            width: 30
        },
        {
            header: 'Overdue',
            dataIndex: 'overdue',
            renderer: renderTicketOverdue,
            sortable: true,
            width: 30
        },
        {
            header: 'Priority',
            dataIndex: 'priority',
            renderer: renderTicketPriority,
            sortable: true,
            width: 30
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
            width: 30
        },
        {
            header: 'Product',
            dataIndex: 'product',
            renderer: renderProduct,
            sortable: true,
            width: 50
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
            width: 30
        },
        {
            header: 'Misc',
            dataIndex: 'id',
            renderer: renderTicketMiscInfo,
            width: 20
        }]
    });
    modISV.grid.Tickets.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Tickets, modISV.Grid, {
    viewTicket: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=ticket&id=' + this.menu.record.id;
    },
    viewTicketInFrontEnd: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = MODx.config.site_url + 'index.php?id=' + MODx.config['modisv.view_ticket_page'] + '&guid=' + this.menu.record.guid;
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
