
modISV.window.Message = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'message',
        labelAlign: 'left',
        labelWidth: 50
    });
    modISV.window.Message.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Message, modISV.Window);
Ext.reg('modisv-window-message', modISV.window.Message);
