
modISV.panel.Milestone = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        baseCls: 'modx-formpanel',
        items: [{
            html: '<h2>Milestone</h2>',
            id: 'modisv-panel-milestone-header',
            border: false,
            cls: 'modx-page-header'
        },
        {
            xtype: 'modisv-tabs',
            items: {
                title: 'Tickets',
                items:  [{
                    html: '<p>Here you can manage your tickets under the milestone.</p><br />',
                    border: false
                },
                {
                    xtype: 'modisv-grid-tickets',
                    baseParams: {
                        action: 'mgr/ticket/getlist',
                        product: modISV.request.product,
                        target_version: modISV.request.target_version
                    },
                    preventRender: true,
                    id: 'gridTickets',
                    tbar: [{
                        text: 'Create Ticket',
                        handler: this.createTicket,
                        scope: this
                    }, '-', {
                        text: 'Bulk Actions',
                        menu: [{
                            text: 'Remove Selected',
                            handler: this.removeSelected,
                            scope: this
                        },
                        {
                            text: 'Close Selected',
                            handler: this.closeSelected,
                            scope: this
                        }]
                    }, '->', 'Topic:',
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
            }
        }]
    });
    modISV.panel.Milestone.superclass.constructor.call(this, config);
    this.loadName();
};
Ext.extend(modISV.panel.Milestone, MODx.Panel, {
    createTicket: function(btn, e) {
        var win = MODx.load({
            xtype: 'modisv-window-new-ticket',
            listeners: {
                'success': {
                    fn: function () {
                        Ext.getCmp('gridTickets').refresh();
                    }
                }
            }
        });
        // create ticket under this milestone
        win.fp.getForm().setValues({
            'product': modISV.request.product,
            'target_version': modISV.request.name
        });
        win.show(e.target);
    },
    removeSelected: function() {
        var grid = Ext.getCmp('gridTickets');
        var cs = grid.getSelectedAsList();
        if (cs === false) return false;

        MODx.Ajax.request({
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/ticket/removeMultiple',
                ids: cs
            },
            listeners: {
                'success': {
                    fn:function(r) {
                        this.getSelectionModel().clearSelections(true);
                        this.refresh();
                    },
                    scope:grid
                }
            }
        });
        return true;
    },
    closeSelected: function() {
        var grid = Ext.getCmp('gridTickets');
        var cs = grid.getSelectedAsList();
        if (cs === false) return false;

        MODx.Ajax.request({
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/ticket/closeMultiple',
                ids: cs
            },
            listeners: {
                'success': {
                    fn:function(r) {
                        this.getSelectionModel().clearSelections(true);
                        this.refresh();
                    },
                    scope:grid
                }
            }
        });
        return true;
    },
    loadName: function() {
        // get the product name via ajax request
        MODx.Ajax.request({
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/product/get',
                id: modISV.request.product
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        Ext.getCmp('modisv-panel-milestone-header').getEl().update('<h2>Milestone - ' + r.object['name'] + ' ' + modISV.request.name + '</h2>');
                    },
                    scope: this
                }
            }
        });
    },
    search: function(btn, e) {
        var grid = Ext.getCmp('gridTickets');
        grid.getStore().baseParams = {
            action: 'mgr/ticket/getlist',
            product: modISV.request.product,
            target_version: modISV.request.target_version,
            topic: Ext.getCmp('queryTopic').getValue(),
            status: Ext.getCmp('queryStatus').getValue(),
            text: Ext.getCmp('queryText').getValue(),
            dateType: Ext.getCmp('queryDateType').getValue(),
            dateFrom: Ext.getCmp('queryDateFrom').getValue(),
            dateTo: Ext.getCmp('queryDateTo').getValue()
        };
        grid.getBottomToolbar().changePage(1);
        grid.refresh();
    },
    reset: function(btn, e) {
        Ext.getCmp('queryTopic').setValue('');
        Ext.getCmp('queryStatus').setValue('');
        Ext.getCmp('queryText').setValue('');
        Ext.getCmp('queryDateFrom').setValue('');
        Ext.getCmp('queryDateTo').setValue('');
        this.search();
    }

});
Ext.reg('modisv-panel-milestone', modISV.panel.Milestone);