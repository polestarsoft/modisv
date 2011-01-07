
modISV.panel.Products = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        headerText: 'Products',
        tabs: [{
            title: 'Products',
            items: [{
                html: '<p>Here you can manage your products.</p><br />',
                border: false
            },
            {
                xtype: 'modisv-grid-products',
                preventRender: true
            }]
        }]
    });
    modISV.panel.Products.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Products, modISV.ListPanel);
Ext.reg('modisv-panel-products', modISV.panel.Products);