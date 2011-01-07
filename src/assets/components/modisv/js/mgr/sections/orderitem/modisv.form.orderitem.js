
modISV.form.OrderItem = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                description: 'The name of the order item.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Unit Price ($)',
                name: 'unit_price',
                description: 'The unit price of the order item, e.g. 99.95.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Quantity',
                name: 'quantity',
                description: 'The quantity of the order item, e.g. 2.',
                width: 300
            },
            {
                xtype: 'modisv-combo-orderitem-action',
                fieldLabel: 'Action',
                name: '_action', // to avoid overriding MODx.Window.action
                hiddenName: '_action',
                description: 'The action to exceute when fulfiling the order item.',
                width: 300
            },
            {
                xtype: 'modisv-combo-edition',
                fieldLabel: 'Edition',
                name: 'edition',
                hiddenName: 'edition',
                description: 'The edition of the corresponding license.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'License',
                name: 'license',
                description: 'The ID of the corresponding license.',
                width: 300
            },
            {
                xtype: 'modisv-licensetypefield',
                fieldLabel: 'License Type',
                name: 'license_type',
                description: 'The type of license to create, if the action is \'license\'.',
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
                xtype: config.update ? 'displayfield' : '',
                fieldLabel: config.update ? 'Total ($)' : '',
                name: 'total',
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.OrderItem.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.OrderItem, MODx.FormPanel);
Ext.reg('modisv-form-orderitem', modISV.form.OrderItem);