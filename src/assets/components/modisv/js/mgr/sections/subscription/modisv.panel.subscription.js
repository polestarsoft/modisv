
modISV.panel.Subscription = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'subscription'
    });
    modISV.panel.Subscription.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Subscription, modISV.UpdatePanel);
Ext.reg('modisv-panel-subscription', modISV.panel.Subscription);
