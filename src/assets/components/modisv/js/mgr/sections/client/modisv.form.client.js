
modISV.form.Client = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                description: 'The name of the client, e.g. Polestarsoft.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Sort Order',
                name: 'sort_order',
                width: 300,
                value: 100
            },
            {
                xtype: 'modisv-combo-client-category',
                fieldLabel: 'Category',
                name: 'category',
                hiddenName: 'category',
                description: 'The client category.',
                width: 300
            },
            {
                xtype: 'modx-combo-browser',
                browserEl: 'modx-browser',
                prependPath: false,
                prependUrl: false,
                hideFiles: true,
                fieldLabel: 'Logo',
                name: 'logo_path',
                maxLength: 255
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Website',
                name: 'website',
                description: 'The website of the client.',
                width: 300
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Testimonial',
                name: 'testimonial',
                grow: true,
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.Client.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Client, MODx.FormPanel);
Ext.reg('modisv-form-client', modISV.form.Client);