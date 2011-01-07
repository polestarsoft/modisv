
modISV.form.Coupon = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                description: 'The name of the coupon, e.g. Holiday Discount.',
                width: 300
            },
            {
                xtype: 'modisv-randomfield',
                fieldLabel: 'Code',
                name: 'code',
                length: 7,
                lowercase: false,
                editable: true,
                description: 'The coupon code.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Discount',
                name: 'discount',
                description: 'The discount of the coupon. A percent value or an amount value corresponding to the field below.',
                width: 300
            },
            {
                xtype: 'checkbox',
                fieldLabel: 'Discount in percent',
                name: 'discount_in_percent',
                description: 'Whether the above discount value is a percent.'
            },
            {
                xtype: 'checkbox',
                fieldLabel: 'Enabled',
                checked: true,
                name: 'enabled',
                description: 'Whether the coupon is enabled.'
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Quantity',
                name: 'quantity',
                description: 'How many times the coupon can be used.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Used',
                name: 'used',
                description: 'How many times the coupon has been used.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Applicable Editions',
                name: 'editions',
                description: 'A comma separated list of IDs of the applicable editions, e.g. "5,7". Leave blank to apply to all editions.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Applicable Actions',
                name: 'actions',
                description: 'A comma separated list of applicable order item actions, e.g. "license,renew". Leave blank to apply to all actions.',
                width: 300
            },
            {
                xtype: 'datefield',
                altFormats: 'Y-m-d H:i:s',
                fieldLabel: 'Valid From',
                name: 'valid_from',
                description: 'When the coupon becomes valid.',
                width: 300
            },
            {
                xtype: 'datefield',
                altFormats: 'Y-m-d H:i:s',
                fieldLabel: 'Valid To',
                name: 'valid_to',
                description: 'When the coupon becomes invalid.',
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.Coupon.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Coupon, MODx.FormPanel);
Ext.reg('modisv-form-coupon', modISV.form.Coupon);