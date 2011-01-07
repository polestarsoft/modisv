
modISV.window.Client = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'client',
        parentEntity: 'product'
    });
    modISV.window.Client.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Client, modISV.CreateWindow);
Ext.reg('modisv-window-client', modISV.window.Client);
