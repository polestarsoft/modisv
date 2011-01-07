
modISV.form.License = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'modisv-licensetypefield',
                fieldLabel: 'Type',
                name: 'type',
                description: 'The license type, e.g. Single User License for Academic.',
                width: 300
            },
            {
                xtype: 'modisv-combo-edition',
                fieldLabel: 'Edition',
                name: 'edition',
                hiddenName: 'edition',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Quantity',
                name: 'quantity',
                width: 300
            },
            {
                xtype: 'datefield',
                altFormats: 'Y-m-d H:i:s',
                fieldLabel: 'Subscription Expiry',
                name: 'subscription_expiry',
                description: 'When will the subscription expires',
                width: 300
            },
            {
                xtype: 'modisv-combo-user',
                fieldLabel: 'User',
                name: 'user',
                hiddenName: 'user',
                description: 'The email of the license holder.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Order',
                name: 'order',
                description: 'The ID of the order that generates the license. (optional)',
                width: 300
            },
            {
                xtype: config.update ? 'textarea' : '',
                fieldLabel: config.update ? 'Code' : '',
                name: 'code',
                description: 'The license code',
                width: 300
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Log',
                name: 'log',
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.License.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.License, MODx.FormPanel);
Ext.reg('modisv-form-license', modISV.form.License);