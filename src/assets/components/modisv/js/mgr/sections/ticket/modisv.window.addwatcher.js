
modISV.window.AddWatcher = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/ticket/addwatcher',
            id: config.record.id
        },
        title: 'Add Watcher',
        height: 150,
        width: 530,
        labelAlign: 'right',
        labelWidth: 140,
        keys: {}, // to suppress enter-submit
        fields: [{
            xtype: 'textfield',
            fieldLabel: 'Full Name',
            name: 'fullname',
            width: 300
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Email',
            name: 'email',
            width: 300
        }]
    });
    modISV.window.AddWatcher.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.AddWatcher, MODx.Window);
Ext.reg('modisv-window-add-watcher', modISV.window.AddWatcher);
