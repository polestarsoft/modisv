
modISV.panel.Coupon = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'coupon'
    });
    modISV.panel.Coupon.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Coupon, modISV.UpdatePanel);
Ext.reg('modisv-panel-coupon', modISV.panel.Coupon);
