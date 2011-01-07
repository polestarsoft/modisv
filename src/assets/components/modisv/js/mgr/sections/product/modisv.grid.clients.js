
modISV.grid.Clients = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/client/getlist',
            product: modISV.request.id
        },
        fields: ['id', 'name', 'sort_order', 'category', 'logo_path', 'website','testimonial', 'menu'],
        columns: [{
            header: 'ID',
            dataIndex: 'id',
            sortable: true,
            width: 50
        },
        {
            header: 'Name',
            dataIndex: 'name',
            sortable: true,
            width: 100
        },
        {
            header: 'Sort Order',
            dataIndex: 'sort_order',
            sortable: true,
            width: 100
        },
        {
            header: 'Category',
            dataIndex: 'category',
            sortable: true,
            width: 100
        },
        {
            header: 'Logo',
            dataIndex: 'logo_path',
            renderer: renderImageSmall,
            width: 100
        },
        {
            header: 'Website',
            dataIndex: 'website',
            width: 100
        },
        {
            header: 'Testimonial',
            dataIndex: 'testimonial',
            renderer: renderEllipsis,
            width: 100
        }],
        tbar: [{
            text: 'Create Client',
            handler: this.createClient,
            scope: this
        }]
    });
    modISV.grid.Clients.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Clients, modISV.Grid, {
    windows: {},
    createClient: function (btn, e) {
        var win = MODx.load({
            xtype: 'modisv-window-client',
            listeners: {
                'success': {
                    fn: function () {
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
        win.show(e.target);
    },
    updateClient: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=client&id=' + this.menu.record.id;
    },
    removeClient: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Client',
            text: 'Are you sure you want to remove this client? All its editions/updates/files will also be removed.',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/client/remove',
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
Ext.reg('modisv-grid-clients', modISV.grid.Clients);