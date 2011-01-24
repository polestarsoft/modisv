
modISV.grid.Licenses = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-licenses',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/license/getlist'
        },
        fields: ['id', 'type', 'quantity', 'createdon', 'subscription_expiry', 'code', 'log', 'user', 'user_email', 'order', 'edition', 'edition_name', 'menu'],
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
            header: 'Type',
            dataIndex: 'type',
            renderer: renderLicenseType,
            sortable: true,
            width: 100
        },
        {
            header: 'Edition',
            dataIndex: 'edition',
            renderer: renderEdition,
            sortable: true,
            width: 100
        },
        {
            header: 'Quantity',
            dataIndex: 'quantity',
            sortable: true,
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
            header: 'Subscription Expiry',
            dataIndex: 'subscription_expiry',
            sortable: true,
            renderer: renderDate,
            width: 60
        },
        {
            header: 'Code',
            dataIndex: 'code',
            sortable: true,
            renderer: renderLicenseCode,
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
            header: 'Order',
            dataIndex: 'order',
            sortable: true,
            renderer: renderOrder,
            width: 60
        },
        {
            header: 'Log',
            dataIndex: 'log',
            renderer: renderEllipsis,
            width: 30
        }],
        tbar: [{
            text: 'Create License',
            handler: this.createLicense,
            scope: this
        }, '->', 'User:',
        {
            xtype: 'textfield',
            emptyText: 'Search',
            id: 'queryUser'
        }, ' ', 'Code:',
        {
            xtype: 'textfield',
            emptyText: 'Search',
            id: 'queryCode'
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
        }, ' ', 'Edition:',
        {
            xtype: 'modisv-combo-edition',
            emptyText: 'Search',
            id: 'queryEdition'
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
    modISV.grid.Licenses.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Licenses, MODx.grid.Grid, {
    windows: {},
    createLicense: function (btn, e) {
        MODx.load({
            xtype: 'modisv-window-license',
            listeners: {
                'success': {
                    fn: function () {
                        this.refresh();
                    },
                    scope: this
                }
            }
        }).show(e.target);
    },
    updateLicense: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=license&id=' + this.menu.record.id;
    },
    removeLicense: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove License',
            text: 'Are you sure you want to remove this license?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/license/remove',
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
            action: 'mgr/license/getlist',
            user: Ext.getCmp('queryUser').getValue(),
            dateFrom: Ext.getCmp('queryDateFrom').getValue(),
            dateTo: Ext.getCmp('queryDateTo').getValue(),
            edition: Ext.getCmp('queryEdition').getValue()
        };
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    reset: function(btn, e) {
        Ext.getCmp('queryUser').setValue('');
        Ext.getCmp('queryDateFrom').setValue('');
        Ext.getCmp('queryDateTo').setValue('');
        Ext.getCmp('queryEdition').setValue('');
        this.search();
    }
});
Ext.reg('modisv-grid-licenses', modISV.grid.Licenses);