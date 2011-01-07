
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-product'
    });
});

modISV.page.Product = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-product',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Product.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Product, MODx.Component);
Ext.reg('modisv-page-product', modISV.page.Product);