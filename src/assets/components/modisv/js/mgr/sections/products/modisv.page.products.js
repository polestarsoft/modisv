
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-products'
    });
});

modISV.page.Products = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-products',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Products.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Products, MODx.Component);
Ext.reg('modisv-page-products', modISV.page.Products);