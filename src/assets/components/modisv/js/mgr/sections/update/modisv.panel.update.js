
modISV.panel.Update = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'update',
        headerField: 'version'
    });
    modISV.panel.Update.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Update, modISV.UpdatePanel);
Ext.reg('modisv-panel-update', modISV.panel.Update);
