
modISV.window.Order = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'order'
    });
    modISV.window.Order.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Order, modISV.CreateWindow);
Ext.reg('modisv-window-order', modISV.window.Order);
