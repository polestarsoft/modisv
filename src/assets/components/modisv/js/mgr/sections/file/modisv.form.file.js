
modISV.form.File = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                description: 'The title of the file, e.g. MODx Installer.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Subtitle',
                name: 'subtitle',
                description: 'The subtitle of the file, e.g. x86.',
                width: 300
            },
            {
                xtype: 'modisv-combo-file-icon',
                fieldLabel: 'Icon',
                name: 'icon',
                hiddenName: 'icon',
                description: 'An icon that will be placed beside the file\'s download link.',
                width: 300
            },
            {
                xtype: 'modx-combo-browser',
                fieldLabel: 'Path',
                name: 'path',
                description: 'The virtual path of the file, without the leading \'/\'.',
                browserEl: 'modx-browser',
                prependPath: false,
                prependUrl: false,
                hideFiles: true,
                maxLength: 255
            },
            {
                xtype: config.update ? 'displayfield' : '',
                fieldLabel: config.update ? 'GUID' : '',
                name: 'guid',
                description: 'The guid of the file.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Download Count',
                name: 'download_count',
                description: 'How many times the file was downloaded.',
                width: 300
            },
            {
                xtype: 'checkbox',
                fieldLabel: 'Members Only',
                name: 'members_only',
                description: 'If this box is checked, only members are allowed to download the file.',
                width: 300
            },
            {
                xtype: 'checkbox',
                fieldLabel: 'Customers Only',
                name: 'customers_only',
                description: 'If this box is checked, only customers are allowed to download the file.',
                width: 300
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Description',
                name: 'description',
                description: 'The description text of the file.',
                grow: true,
                width: 300
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Requirements',
                name: 'requirements',
                description: 'The system requirements of the file.',
                grow: true,
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.File.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.File, MODx.FormPanel);
Ext.reg('modisv-form-file', modISV.form.File);

