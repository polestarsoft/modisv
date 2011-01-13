
modISV.window.Response = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'response'
    });
    modISV.window.Response.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Response, modISV.Window);
Ext.reg('modisv-window-response', modISV.window.Response);
