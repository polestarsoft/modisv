
modISV.form.Release = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                description: 'The name of the release, e.g. 2.0RC.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Version',
                name: 'version',
                description: 'The version of the release, e.g. 2.0.',
                width: 300
            },
            {
                xtype: 'checkbox',
                fieldLabel: 'Beta',
                name: 'beta',
                description: 'Check this box if the release is a beta release.'
            },
            {
                xtype: 'modisv-combo-licensing-mode',
                fieldLabel: 'Licensing Mode',
                name: 'licensing_mode',
                hiddenName: 'licensing_mode',
                description: 'Licensing mode of the release.',
                width: 300
            },
            {
                xtype: 'modisv-combo-licensing-method',
                fieldLabel: 'Licensing Method',
                name: 'licensing_method',
                hiddenName: 'licensing_method',
                description: 'Licensing method of the release.',
                width: 300
            },
            {
                xtype: 'modisv-combo-snippet',
                fieldLabel: 'Code Generator',
                name: 'code_generator',
                hiddenName: 'code_generator',
                description: 'The snippet to generate license code, e.g. miRsaSha1.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Initial Subscription',
                name: 'initial_subscription',
                description: 'How many months will be added to the subscription of the new-purchased license of this release.',
                width: 300
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Changes',
                name: 'changes',
                description: 'What\'s new in this release.',
                grow: true,
                width: 300
            },
            {
                xtype: config.update ? 'textarea' : '',
                fieldLabel: config.update ? 'Upgrade Rules' : '',
                name: 'upgrade_rules',
                description: 'The rules of upgrading from editions in previous release to editions in current release. Rule format: \'PrevEdition -> CurrEdition\'.',
                grow: true,
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.Release.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Release, MODx.FormPanel);
Ext.reg('modisv-form-release', modISV.form.Release);