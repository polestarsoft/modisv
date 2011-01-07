
modISV.panel.Order = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'order',
        extraTabs: [{
            title: 'Items',
            items: [{
                xtype: 'modisv-grid-orderitems',
                preventRender: true
            }]
        }]
    });
    modISV.panel.Order.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Order, modISV.UpdatePanel);
Ext.reg('modisv-panel-order', modISV.panel.Order);
