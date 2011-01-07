
modISV.form.Subscription = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                description: 'The name of the subscription, without the trailing \'Subscription\', e.g. Next Year.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Price Percentage',
                name: 'price',
                description: 'The actual cost of the subscription equals to this value multiplying the license\'s price, e.g. 30.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Subscription Months',
                name: 'months',
                description: 'How many months the subscription contains.',
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.Subscription.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Subscription, MODx.FormPanel);
Ext.reg('modisv-form-subscription', modISV.form.Subscription);