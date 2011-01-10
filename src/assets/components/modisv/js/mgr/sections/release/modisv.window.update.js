
modISV.window.Update = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'update',
        parentEntity: 'release'
    });
    modISV.window.Update.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Update, modISV.Window);
Ext.reg('modisv-window-update', modISV.window.Update);
