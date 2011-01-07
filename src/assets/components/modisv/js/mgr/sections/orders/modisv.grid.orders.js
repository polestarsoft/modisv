
modISV.grid.Orders = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-orders',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/order/getlist'
        },
        fields: ['id', 'status', 'guid', 'coupon', 'total', 'createdon', 'updatedon', 'reference_number', 'payment_processor', 'test_mode', 'payment_method', 'user', 'user_email', 'menu'],
        autoHeight: true,
        paging: true,
        pageSize: 30,
        columns: [{
            header: 'ID',
            dataIndex: 'id',
            sortable: true,
            width: 50
        },
        {
            header: 'GUID',
            dataIndex: 'guid',
            width: 100
        },
        {
            header: 'Status',
            dataIndex: 'status',
            sortable: true,
            width: 60
        },
        {
            header: 'Coupon Code',
            dataIndex: 'coupon',
            sortable: true,
            width: 60
        },
        {
            header: 'Total',
            dataIndex: 'total',
            sortable: true,
            renderer: renderCurrency,
            width: 60
        },
        {
            header: 'Created On',
            dataIndex: 'createdon',
            sortable: true,
            renderer: renderDate,
            width: 60
        },
        {
            header: 'Updated On',
            dataIndex: 'updatedon',
            sortable: true,
            renderer: renderDate,
            width: 60
        },
        {
            header: 'Reference Number',
            dataIndex: 'reference_number',
            sortable: true,
            width: 100
        },
        {
            header: 'Payment Processor',
            dataIndex: 'payment_processor',
            sortable: true,
            width: 100
        },
        {
            header: 'Payment Method',
            dataIndex: 'payment_method',
            sortable: true,
            width: 100
        },
        {
            header: 'User',
            dataIndex: 'user',
            renderer: renderUser,
            sortable: true,
            width: 100
        },
        {
            header: 'Test Mode',
            dataIndex: 'test_mode',
            renderer: renderBoolean,
            sortable: true,
            width: 50
        }],
        tbar: [{
            xtype: 'tbsplit',
            text: 'Create Order',
            handler: this.createOrder,
            scope: this,
            menu : {
                items: [{
                    text: 'License Order',
                    handler: this.createLicenseOrder,
                    scope: this
                }, {
                    text: 'Upgrade Order',
                    handler: this.createUpgradeOrder,
                    scope: this
                }, {
                    text: 'Renew Order',
                    handler: this.createRenewOrder,
                    scope: this
                }]
            }
        }, '->', 'User:',
        {
            xtype: 'textfield',
            emptyText: 'Search',
            id: 'queryUser'
        }, ' ', 'Guid:',
        {
            xtype: 'textfield',
            emptyText: 'Search',
            id: 'queryGUID'
        }, ' ', 'Ref No.:',
        {
            xtype: 'textfield',
            emptyText: 'Search',
            id: 'queryRefNo'
        }, ' ', 'Date:',
        {
            xtype: 'datefield',
            emptyText: 'From',
            id: 'queryDateFrom'
        },
        {
            xtype: 'datefield',
            emptyText: 'To',
            id: 'queryDateTo'
        }, ' ', 'Status:',
        {
            xtype: 'modisv-combo-order-status',
            emptyText: 'Search',
            id: 'queryStatus'
        }, ' ', 'Processor:',
        {
            xtype: 'modisv-combo-payment-processor',
            emptyText: 'Search',
            id: 'queryProcessor'
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
    });
    modISV.grid.Orders.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Orders, MODx.grid.Grid, {
    windows: {},
    createOrder: function (btn, e) {
        var win = MODx.load({
            xtype: 'modisv-window-order',
            listeners: {
                'success': {
                    fn: function (p) {
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
        win.show(e.target);
    },
    createLicenseOrder: function(btn, e) {
        var win = MODx.load({
            xtype: 'modisv-window-create-license-order',
            listeners: {
                'success': {
                    fn: function (p) {
                        Ext.Msg.alert('Order Created', 'The payment URL is:<br /><a href="' + p.a.result.object.url + '">' + p.a.result.object.url + '</a>');
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
        win.show(e.target);
    },
    createUpgradeOrder: function(btn, e) {
        var win = MODx.load({
            xtype: 'modisv-window-create-upgrade-order',
            listeners: {
                'success': {
                    fn: function (p) {
                        Ext.Msg.alert('Order Created', 'The payment URL is:<br /><a href="' + p.a.result.object.url + '">' + p.a.result.object.url + '</a>');
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
        win.show(e.target);
    },
    createRenewOrder: function(btn, e) {
        var win = MODx.load({
            xtype: 'modisv-window-create-renew-order',
            listeners: {
                'success': {
                    fn: function (p) {
                        Ext.Msg.alert('Order Created', 'The payment URL is:<br /><a href="' + p.a.result.object.url + '">' + p.a.result.object.url + '</a>');
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
        win.show(e.target);
    },
    updateOrder: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=order&id=' + this.menu.record.id;
    },
    removeOrder: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Order',
            text: 'Are you sure you want to remove this order?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/order/remove',
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
    },
    search: function(btn, e) {
        this.getStore().baseParams = {
            action: 'mgr/order/getlist',
            user: Ext.getCmp('queryUser').getValue(),
            guid: Ext.getCmp('queryGUID').getValue(),
            refno: Ext.getCmp('queryRefNo').getValue(),
            dateFrom: Ext.getCmp('queryDateFrom').getValue(),
            dateTo: Ext.getCmp('queryDateTo').getValue(),
            status: Ext.getCmp('queryStatus').getValue(),
            processor: Ext.getCmp('queryProcessor').getValue()
        };
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    reset: function(btn, e) {
        Ext.getCmp('queryUser').setValue('');
        Ext.getCmp('queryGUID').setValue('');
        Ext.getCmp('queryRefNo').getValue();
        Ext.getCmp('queryDateFrom').setValue('');
        Ext.getCmp('queryDateTo').setValue('');
        Ext.getCmp('queryStatus').setValue('');
        Ext.getCmp('queryProcessor').setValue('');
        this.search();
    },
    fulfillOrder: function(btn, e) {
        var fulfillWindow = MODx.load({
            xtype: 'modisv-window-fulfill-order',
            record: this.menu.record,
            listeners: {
                'success': {
                    fn:this.refresh,
                    scope:this
                }
            }
        });
        fulfillWindow.setValues({
            email: this.menu.record.user_email
        });
        fulfillWindow.show(e.target);
    }
});
Ext.reg('modisv-grid-orders', modISV.grid.Orders);