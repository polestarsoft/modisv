
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-orderitem'
    });
});

modISV.page.OrderItem = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-orderitem',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.OrderItem.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.OrderItem, MODx.Component);
Ext.reg('modisv-page-orderitem', modISV.page.OrderItem);