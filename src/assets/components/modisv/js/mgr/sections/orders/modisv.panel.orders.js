
modISV.panel.Orders = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        headerText: 'Orders',
        tabs: [{
            title: 'Orders',
            items: [{
                html: '<p>Here you can manage your orders.</p><br />',
                border: false
            },
            {
                xtype: 'modisv-grid-orders',
                preventRender: true
            }]
        }]
    });
    modISV.panel.Orders.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Orders, modISV.ListPanel);
Ext.reg('modisv-panel-orders', modISV.panel.Orders);