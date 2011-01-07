
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-orders'
    });
});

modISV.page.Orders = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-orders',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Orders.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Orders, MODx.Component);
Ext.reg('modisv-page-orders', modISV.page.Orders);