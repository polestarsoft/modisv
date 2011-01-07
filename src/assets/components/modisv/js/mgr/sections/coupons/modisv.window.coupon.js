
modISV.window.Coupon = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'coupon'
    });
    modISV.window.Coupon.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Coupon, modISV.CreateWindow);
Ext.reg('modisv-window-coupon', modISV.window.Coupon);
