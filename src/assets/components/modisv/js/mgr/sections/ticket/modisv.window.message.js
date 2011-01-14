
modISV.window.Message = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/message/update',
            id: config.record.id
        },
        title: 'Update Message',
        height: 150,
        width: 530,
        labelAlign: 'left',
        labelWidth: 50,
        keys: {}, // to suppress enter-submit
        fields: [{
            xtype: 'modisv-maskdowneditor',
            fieldLabel: 'Body',
            name: 'body',
            width: '90%',
            grow: true,
            growMax: 300
        },
        {
            xtype: 'hidden',
            name: 'id'
        }]
    });
    modISV.window.Message.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Message, MODx.Window);
Ext.reg('modisv-window-message', modISV.window.Message);
