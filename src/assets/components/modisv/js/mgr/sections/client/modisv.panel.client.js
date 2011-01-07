
modISV.panel.Client = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'client'
    });
    modISV.panel.Client.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Client, modISV.UpdatePanel);
Ext.reg('modisv-panel-client', modISV.panel.Client);