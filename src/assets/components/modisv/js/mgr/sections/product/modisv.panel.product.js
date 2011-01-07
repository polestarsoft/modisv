
modISV.panel.Product = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'product',
        extraTabs: [{
            title: 'Releases',
            items: [{
                xtype: 'modisv-grid-releases',
                preventRender: true
            }]
        },
        {
            title: 'Clients',
            items: [{
                xtype: 'modisv-grid-clients',
                preventRender: true
            }]
        }]
    });
    modISV.panel.Product.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Product, modISV.UpdatePanel);
Ext.reg('modisv-panel-product', modISV.panel.Product);