
modISV.window.NewTicket = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/ticket/create'
        },
        title: 'New Ticket',
        height: 150,
        width: 630,
        labelAlign: 'right',
        labelWidth: 140,
        keys: {}, // to suppress enter-submit
        fields: [{
            xtype: 'modisv-combo-ticket-topic',
            fieldLabel: 'Topic',
            name: 'topic',
            hiddenName: 'topic',
            width: 400
        },
        {
            xtype: 'modisv-combo-ticket-priority',
            fieldLabel: 'Priority',
            name: 'priority',
            hiddenName: 'priority',
            description: 'Larger value represents higher priority.',
            width: 400
        },
        {
            xtype: 'modisv-combo-product',
            fieldLabel: 'Product',
            name: 'product',
            hiddenName: 'product',
            width: 400
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Target Version',
            name: 'target_version',
            value: 'unplanned',
            width: 400
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Subjuect',
            name: 'subject',
            width: 400
        },
        {
            xtype: 'modisv-maskdowneditor',
            fieldLabel: 'Body',
            name: 'body',
            width: 400,
            grow: true,
            growMax: 300
        },
        {
            xtype: 'datefield',
            altFormats: 'Y-m-d H:i:s',
            fieldLabel: 'Due On',
            name: 'dueon',
            description: 'When will the ticket become overdue.',
            width: 400
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Note',
            name: 'note',
            width: 400
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Watchers',
            name: 'watchers',
            width: 400
        }]
    });
    modISV.window.NewTicket.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.NewTicket, MODx.Window);
Ext.reg('modisv-window-new-ticket', modISV.window.NewTicket);
