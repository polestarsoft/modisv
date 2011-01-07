
modISV.window.File = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'file',
        parentEntity: 'release'
    });
    modISV.window.File.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.File, modISV.CreateWindow);
Ext.reg('modisv-window-file', modISV.window.File);
