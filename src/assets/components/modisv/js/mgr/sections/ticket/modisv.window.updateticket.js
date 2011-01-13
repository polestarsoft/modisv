
modISV.window.UpdateTicket = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/ticket/update',
            id: config.record.id
        },
        title: 'Update Ticket',
        height: 150,
        width: 530,
        labelAlign: 'right',
        labelWidth: 140,
        keys: {}, // to suppress enter-submit
        fields: [{
            xtype: 'modisv-combo-ticket-status',
            fieldLabel: 'Status',
            name: 'status',
            width: 300
        },
        {
            xtype: 'modisv-combo-ticket-topic',
            fieldLabel: 'Topic',
            name: 'topic',
            width: 300
        },
        {
            xtype: 'modisv-combo-ticket-priority',
            fieldLabel: 'Priority',
            name: 'priority',
            description: 'Larger value represents higher priority.',
            width: 300
        },
        {
            xtype: 'modisv-combo-product',
            fieldLabel: 'Product',
            name: 'product',
            width: 300
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Subjuect',
            name: 'subject',
            width: 300
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Target Version',
            name: 'target_version',
            value: 'unplanned',
            width: 300
        },
        {
            xtype: 'datefield',
            altFormats: 'Y-m-d H:i:s',
            fieldLabel: 'Due On',
            name: 'dueon',
            description: 'When will the ticket become overdue.',
            width: 300
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Note',
            name: 'note',
            width: 300
        },
        {
            xtype: 'textfield',
            fieldLabel: 'Watchers',
            name: 'watchers',
            width: 300
        },
        {
            xtype: 'hidden',
            name: 'id'
        }]
    });
    modISV.window.UpdateTicket.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.UpdateTicket, MODx.Window);
Ext.reg('modisv-window-update-ticket', modISV.window.UpdateTicket);
