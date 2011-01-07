
modISV.form.Product = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                description: 'The name of the product, e.g. MODx.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Alias',
                name: 'alias',
                description: 'The alias of the product, e.g. modx .',
                width: 300
            },
            {
                xtype: 'checkbox',
                fieldLabel: 'Desktop Application',
                name: 'desktop_application',
                description: 'Check this box if the product is a desktop application.'
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
                xtype: 'numberfield',
                fieldLabel: 'Sort Order',
                name: 'sort_order',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Overview Url',
                name: 'overview_url',
                description: 'The url of the product overview page, defaults to products/ALIAS if left empty.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Download Url',
                name: 'download_url',
                description: 'The url of the product download page, defaults to download/ALIAS if left empty.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Order Url',
                name: 'order_url',
                description: 'The url of the product order page, defaults to store/ALIAS if left empty.',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'Short Description',
                name: 'short_description',
                description: 'The one-sentense description of the product.',
                width: 300
            },
            {
                xtype: 'textarea',
                fieldLabel: 'Description',
                name: 'description',
                description: 'The full description text of the product.',
                grow: true,
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.Product.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Product, MODx.FormPanel);
Ext.reg('modisv-form-product', modISV.form.Product);