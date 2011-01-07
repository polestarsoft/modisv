
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-subscription'
    });
});

modISV.page.Subscription = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-subscription',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Subscription.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Subscription, MODx.Component);
Ext.reg('modisv-page-subscription', modISV.page.Subscription);