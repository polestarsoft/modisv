
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-coupons'
    });
});

modISV.page.Coupons = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-coupons',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Coupons.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Coupons, MODx.Component);
Ext.reg('modisv-page-coupons', modISV.page.Coupons);