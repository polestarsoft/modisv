
modISV.grid.OrderItems = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-orderitems',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/orderitem/getlist',
            order: modISV.request.id
        },
        fields: ['id', 'name', 'unit_price', 'quantity', 'action', 'subscription_months', 'license_type', 'order', 'license', 'edition', 'edition_name', 'menu'],
        autoHeight: true,
        paging: true,
        columns: [{
            header: 'ID',
            dataIndex: 'id',
            width: 100
        },
        {
            header: 'Name',
            dataIndex: 'name',
            width: 200
        },
        {
            header: 'Unit Price',
            dataIndex: 'unit_price',
            renderer: renderCurrency,
            width: 100
        },
        {
            header: 'Quantity',
            dataIndex: 'quantity',
            width: 100
        },
        {
            header: 'Action',
            dataIndex: 'action',
            width: 100
        },
        {
            header: 'Subscription Months',
            dataIndex: 'subscription_months',
            width: 100
        },
        {
            header: 'License Type',
            dataIndex: 'license_type',
            renderer: renderLicenseType,
            width: 120
        },
        {
            header: 'License',
            dataIndex: 'license',
            renderer: renderLicense,
            width: 50
        },
        {
            header: 'Edition',
            dataIndex: 'edition',
            renderer: renderEdition,
            width: 120
        }],
        tbar: [{
            text: 'Create Order Item',
            handler: this.createOrderItem,
            scope: this
        }]
    });
    modISV.grid.OrderItems.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.OrderItems, MODx.grid.Grid, {
    windows: {},
    createOrderItem: function (btn, e) {
        if (!this.windows.createOrderItem) {
            this.windows.createOrderItem = MODx.load({
                xtype: 'modisv-window-orderitem',
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
        this.windows.createOrderItem.fp.getForm().reset();
        this.windows.createOrderItem.show(e.target);
    },
    updateOrderItem: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=orderitem&id=' + this.menu.record.id;
    },
    removeOrderItem: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Order Item',
            text: 'Are you sure you want to remove this order item?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/orderitem/remove',
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
Ext.reg('modisv-grid-orderitems', modISV.grid.OrderItems);