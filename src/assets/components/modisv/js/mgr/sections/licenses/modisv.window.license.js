
modISV.window.License = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'license'
    });
    modISV.window.License.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.License, modISV.CreateWindow);
Ext.reg('modisv-window-license', modISV.window.License);
