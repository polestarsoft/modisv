
modISV.window.ReplyTicket = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/ticket/reply',
            id: config.record.id
        },
        title: 'Reply Ticket',
        fileUpload: true,
        height: 150,
        width: 730,
        labelAlign: 'left',
        labelWidth: 50,
        keys: {}, // to suppress enter-submit
        fields: [{
            xtype: 'modisv-maskdowneditor',
            fieldLabel: 'Body',
            name: 'body',
            width: 600,
            grow: true,
            growMax: 300
        },
        {
            xtype: 'fileuploadfield',
            fieldLabel: 'File 1',
            name: 'file1',
            width: 600,
            height:26
        },
        {
            xtype: 'fileuploadfield',
            fieldLabel: 'File 2',
            name: 'file2',
            width: 600,
            height:26
        },
        {
            xtype: 'fileuploadfield',
            fieldLabel: 'File 3',
            name: 'file3',
            width: 600,
            height:26
        }]
    });
    modISV.window.ReplyTicket.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.ReplyTicket, MODx.Window);
Ext.reg('modisv-window-reply-ticket', modISV.window.ReplyTicket);
