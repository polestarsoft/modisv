
modISV.panel.Tickets = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        headerText: 'Tickets',
        tabs: [{
            title: 'Tickets',
            items: [{
                html: '<p>Here you can manage your tickets.</p><br />',
                border: false
            },
            {
                xtype: 'modisv-grid-tickets',
                preventRender: true,
                id: 'gridTickets',
                tbar: [{
                    text: 'Create Ticket',
                    handler: this.createTicket,
                    scope: this
                }, '->', 'User:',
                {
                    xtype: 'textfield',
                    emptyText: 'Search',
                    width: 100,
                    id: 'queryUser'
                }, ' ', 'Topic:',
                {
                    xtype: 'modisv-combo-ticket-topic',
                    value: '',
                    emptyText: 'Search',
                    width: 100,
                    id: 'queryTopic'
                }, ' ', 'Status:',
                {
                    xtype: 'modisv-combo-ticket-status',
                    value: '',
                    emptyText: 'Search',
                    width: 100,
                    id: 'queryStatus'
                }, ' ', 'Product:',
                {
                    xtype: 'modisv-combo-product',
                    emptyText: 'Search',
                    width: 100,
                    id: 'queryProduct'
                }, ' ', 'Text:',
                {
                    xtype: 'textfield',
                    emptyText: 'Search',
                    width: 100,
                    id: 'queryText'
                }, ' ', 'Date Type:',
                {
                    xtype: 'modisv-combo-ticket-date-type',
                    width: 100,
                    id: 'queryDateType'
                }, ' ', 'Date:',
                {
                    xtype: 'datefield',
                    emptyText: 'From',
                    width: 100,
                    id: 'queryDateFrom'
                },
                {
                    xtype: 'datefield',
                    emptyText: 'To',
                    width: 100,
                    id: 'queryDateTo'
                },
                {
                    text: 'Search',
                    handler: this.search,
                    scope: this
                },
                {
                    text: 'Reset',
                    handler: this.reset,
                    scope: this
                }]
            }]
        }]
    });
    modISV.panel.Tickets.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Tickets, modISV.ListPanel, {
    createTicket: function(btn, e) {
        var grid = Ext.getCmp('gridTickets');
        MODx.load({
            xtype: 'modisv-window-ticket',
            listeners: {
                'success': {
                    fn: function () {
                        this.refresh();
                    },
                    scope: grid
                }
            }
        }).show(e.target);
    },
    search: function(btn, e) {
        var grid = Ext.getCmp('gridTickets');
        grid.getStore().baseParams = {
            action: 'mgr/ticket/getlist',
            user: Ext.getCmp('queryUser').getValue(),
            topic: Ext.getCmp('queryTopic').getValue(),
            status: Ext.getCmp('queryStatus').getValue(),
            product: Ext.getCmp('queryProduct').getValue(),
            text: Ext.getCmp('queryText').getValue(),
            dateType: Ext.getCmp('queryDateType').getValue(),
            dateFrom: Ext.getCmp('queryDateFrom').getValue(),
            dateTo: Ext.getCmp('queryDateTo').getValue()
        };
        grid.getBottomToolbar().changePage(1);
        grid.refresh();
    },
    reset: function(btn, e) {
        Ext.getCmp('queryUser').setValue('');
        Ext.getCmp('queryTopic').setValue('');
        Ext.getCmp('queryStatus').setValue('');
        Ext.getCmp('queryProduct').setValue('');
        Ext.getCmp('queryText').setValue('');
        Ext.getCmp('queryDateFrom').setValue('');
        Ext.getCmp('queryDateTo').setValue('');
        this.search();
    }
});
Ext.reg('modisv-panel-tickets', modISV.panel.Tickets);