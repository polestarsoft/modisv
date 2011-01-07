
modISV.window.OrderItem = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'orderitem',
        parentEntity: '_order'
    });
    modISV.window.OrderItem.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.OrderItem, modISV.CreateWindow);
Ext.reg('modisv-window-orderitem', modISV.window.OrderItem);
