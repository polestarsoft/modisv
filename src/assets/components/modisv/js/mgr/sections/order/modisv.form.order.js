
modISV.form.Order = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'modisv-combo-order-status',
                fieldLabel: 'Status',
                name: 'status',
                hiddenName: 'status',
                description: 'The order status.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Reference Number',
                name: 'reference_number',
                description: 'The refNo of the order, e.g. 83995736.',
                width: 300
            },
            {
                xtype: 'modisv-combo-payment-processor',
                fieldLabel: 'Payment Processor',
                name: 'payment_processor',
                hiddenName: 'payment_processor',
                description: 'The payment processor of the order.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Payment Method',
                name: 'payment_method',
                description: 'The payment method of the order, e.g. CC.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Coupon Code',
                name: 'coupon',
                description: 'The coupon code used when placing the order.',
                width: 300
            },
            {
                xtype: 'modisv-combo-user',
                fieldLabel: 'User',
                name: 'user',
                hiddenName: 'user',
                description: 'The email of the order\'s user.',
                width: 300
            },
            {
                xtype: 'checkbox',
                fieldLabel: 'Test Mode',
                name: 'test_mode',
                description: 'Check this box if the order is a test order.'
            },
            {
                xtype: config.update ? 'displayfield' : '',
                fieldLabel: config.update ? 'GUID' : '',
                name: 'guid',
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
    modISV.form.Order.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Order, MODx.FormPanel);
Ext.reg('modisv-form-order', modISV.form.Order);