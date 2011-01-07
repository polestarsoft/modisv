
modISV.window.FulfillOrder = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: 'Fulfill Order',
        height: 150,
        width: 500,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/order/fulfill',
            id:config.record.id
        },
        fields: [{
            title: 'User Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Email',
                name: 'email',
                description: 'The email of the user.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Full Name',
                name: 'fullname',
                description: 'The full name of the user.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Company',
                name: 'company',
                description: 'The company of the user.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'License Name',
                name: 'license_name',
                description: 'If specified, the field value will be used as the license name instead of the full name or company name.',
                width: 300
            },
            {
                xtype: 'checkbox',
                fieldLabel: 'Send Email',
                name: 'send_email',
                description: 'Uncheck this box to block the order email.',
                checked: true,
                width: 300
            }]
        }]
    });
    modISV.window.FulfillOrder.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.FulfillOrder, MODx.Window);
Ext.reg('modisv-window-fulfill-order', modISV.window.FulfillOrder);