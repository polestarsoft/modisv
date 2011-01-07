
modISV.panel.OrderItem = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'orderitem',
        headerText: 'Order item'
    });
    modISV.panel.OrderItem.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.OrderItem, modISV.UpdatePanel);
Ext.reg('modisv-panel-orderitem', modISV.panel.OrderItem);
