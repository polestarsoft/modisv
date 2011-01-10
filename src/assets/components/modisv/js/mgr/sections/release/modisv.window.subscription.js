
modISV.window.Subscription = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'subscription',
        parentEntity: 'release'
    });
    modISV.window.Subscription.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Subscription, modISV.Window);
Ext.reg('modisv-window-subscription', modISV.window.Subscription);
