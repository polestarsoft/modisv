
modISV.grid.Products = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-products',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/product/getlist'
        },
        fields: ['id', 'name', 'alias', 'logo_path', 'desktop_application', 'sort_order', 'overview_url', 'short_description', 'description', 'releases', 'menu'],
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
            header: 'Alias',
            dataIndex: 'alias',
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
            header: 'Desktop Application',
            dataIndex: 'desktop_application',
            renderer: renderBoolean,
            width: 100
        },
        {
            header: 'Sort Order',
            dataIndex: 'sort_order',
            width: 50
        },
        {
            header: 'Overview Url',
            dataIndex: 'overview_url',
            renderer: renderLink,
            width: 100
        },
        {
            header: 'Short Description',
            dataIndex: 'short_description',
            width: 250
        },
        {
            header: 'Releases',
            dataIndex: 'releases',
            renderer: renderReleases,
            width: 100
        }],
        tbar: [{
            text: 'Create Product',
            handler: this.createProduct,
            scope: this
        }]
    });
    modISV.grid.Products.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Products, modISV.Grid, {
    windows: {},
    createProduct: function (btn, e) {
        if (!this.windows.createProduct) {
            this.windows.createProduct = MODx.load({
                xtype: 'modisv-window-product',
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
        this.windows.createProduct.fp.getForm().reset();
        this.windows.createProduct.show(e.target);
    },
    updateProduct: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=product&id=' + this.menu.record.id;
    },
    removeProduct: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Product',
            text: 'Are you sure you want to remove this product? All its releases will also be removed.',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/product/remove',
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
Ext.reg('modisv-grid-products', modISV.grid.Products);
