
modISV.window.CreateRenewOrder = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: 'Create License Order',
        height: 150,
        width: 500,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/order/quickcreate'
        },
        fields: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'numberfield',
                fieldLabel: 'License',
                name: 'license',
                description: 'The ID of the corresponding license.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Unit Price',
                name: 'unit_price',
                description: 'The unit price of the renewal, e.g. 99.95.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Subscription Months',
                name: 'subscription_months',
                description: 'How many months to add to the corresponding license\'s subscription.',
                width: 300
            },
            {
                xtype: 'hidden',
                name: '_action', // to avoid overriding MODx.Window.action
                value: 'renew'
            }]
        }]
    });
    modISV.window.CreateRenewOrder.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.CreateRenewOrder, MODx.Window);
Ext.reg('modisv-window-create-renew-order', modISV.window.CreateRenewOrder);