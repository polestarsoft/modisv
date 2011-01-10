
modISV.window.Product = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'product'
    });
    modISV.window.Product.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Product, modISV.Window);
Ext.reg('modisv-window-product', modISV.window.Product);
