
modISV.form.Edition = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                description: 'The name of the edition, e.g. Standard Edition.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Price',
                name: 'price',
                description: 'The price of a single license of the edition, e.g. 99.95.',
                width: 300
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Description',
                name: 'description',
                description: 'The description of the edition, e.g. the differences between this and other editions.',
                grow: true,
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.Edition.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Edition, MODx.FormPanel);
Ext.reg('modisv-form-edition', modISV.form.Edition);