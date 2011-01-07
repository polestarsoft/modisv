
modISV.grid.Subscriptions = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-subscriptions',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/subscription/getlist',
            release: modISV.request.id
        },
        fields: ['id', 'name', 'price', 'months', 'menu'],
        autoHeight: true,
        paging: true,
        columns: [{
            header: 'ID',
            dataIndex: 'id',
            sortable: true,
            width: 100
        },
        {
            header: 'Name',
            dataIndex: 'name',
            sortable: true,
            width: 200
        },
        {
            header: 'Price',
            dataIndex: 'price',
            sortable: true,
            renderer: renderPercentage,
            width: 200
        },
        {
            header: 'Subscription Months',
            dataIndex: 'months',
            width: 300
        }],
        tbar: [{
            text: 'Create Subscription',
            handler: this.createSubscription,
            scope: this
        }]
    });
    modISV.grid.Subscriptions.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Subscriptions, MODx.grid.Grid, {
    windows: {},
    createSubscription: function (btn, e) {
        if (!this.windows.createSubscription) {
            this.windows.createSubscription = MODx.load({
                xtype: 'modisv-window-subscription',
                listeners: {
                    'success': {
                        fn: function () {
                            this.refresh();
                        },
                        scope: this
                    }
                }
            });
        }
        this.windows.createSubscription.fp.getForm().reset();
        this.windows.createSubscription.show(e.target);
    },
    updateSubscription: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=subscription&id=' + this.menu.record.id;
    },
    removeSubscription: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Subscription',
            text: 'Are you sure you want to remove this subscription?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/subscription/remove',
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
Ext.reg('modisv-grid-subscriptions', modISV.grid.Subscriptions);