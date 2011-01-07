
modISV.grid.Editions = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-editions',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/edition/getlist',
            release: modISV.request.id
        },
        fields: ['id', 'name', 'price', 'description', 'menu'],
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
            renderer: renderCurrency,
            width: 200
        },
        {
            header: 'Description',
            dataIndex: 'description',
            width: 300
        }],
        tbar: [{
            text: 'Create Edition',
            handler: this.createEdition,
            scope: this
        }]
    });
    modISV.grid.Editions.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Editions, MODx.grid.Grid, {
    windows: {},
    createEdition: function (btn, e) {
        if (!this.windows.createEdition) {
            this.windows.createEdition = MODx.load({
                xtype: 'modisv-window-edition',
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
        this.windows.createEdition.fp.getForm().reset();
        this.windows.createEdition.show(e.target);
    },
    updateEdition: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=edition&id=' + this.menu.record.id;
    },
    removeEdition: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Edition',
            text: 'Are you sure you want to remove this edition?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/edition/remove',
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
Ext.reg('modisv-grid-editions', modISV.grid.Editions);