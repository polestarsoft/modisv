
modISV.window.Release = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'release',
        parentEntity: 'product'
    });
    modISV.window.Release.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Release, modISV.Window);
Ext.reg('modisv-window-release', modISV.window.Release);
