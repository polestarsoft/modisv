
modISV.window.ReplyTicket = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/ticket/reply',
            id: config.record.id
        },
        title: 'Reply Ticket',
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
    modISV.window.ReplyTicket.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.ReplyTicket, MODx.Window);
Ext.reg('modisv-window-reply-ticket', modISV.window.ReplyTicket);
