
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-order'
    });
});

modISV.page.Order = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-order',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Order.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Order, MODx.Component);
Ext.reg('modisv-page-order', modISV.page.Order);