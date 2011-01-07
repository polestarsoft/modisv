
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-coupon'
    });
});

modISV.page.Coupon = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-coupon',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Coupon.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Coupon, MODx.Component);
Ext.reg('modisv-page-coupon', modISV.page.Coupon);