
modISV.window.CreateLicenseOrder = function (config) {
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
                xtype: 'modisv-combo-edition',
                fieldLabel: 'Edition',
                name: 'edition',
                hiddenName: 'edition',
                description: 'The edition of the license.',
                width: 300
            },
            {
                xtype: 'modisv-licensetypefield',
                fieldLabel: 'License Type',
                name: 'license_type',
                description: 'The type of license to create.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Unit Price',
                name: 'unit_price',
                description: 'The unit price of the license, e.g. 99.95.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Quantity',
                name: 'quantity',
                description: 'The quantity of the license, e.g. 2.',
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
                name: '_action',    // to avoid overriding MODx.Window.action
                value: 'license'
            }]
        }]
    });
    modISV.window.CreateLicenseOrder.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.CreateLicenseOrder, MODx.Window);
Ext.reg('modisv-window-create-license-order', modISV.window.CreateLicenseOrder);