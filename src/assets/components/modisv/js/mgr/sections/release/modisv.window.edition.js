
modISV.window.Edition = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'edition',
        parentEntity: 'release'
    });
    modISV.window.Edition.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Edition, modISV.Window);
Ext.reg('modisv-window-edition', modISV.window.Edition);
