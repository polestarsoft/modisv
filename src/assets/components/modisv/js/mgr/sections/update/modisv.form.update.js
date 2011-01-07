
modISV.form.Update = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Version',
                name: 'version',
                description: 'The version of the update, e.g. 1.0.2.345.',
                width: 300
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Changes',
                name: 'changes',
                description: 'The changes in this update.',
                grow: true,
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.Update.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Update, MODx.FormPanel);
Ext.reg('modisv-form-update', modISV.form.Update);