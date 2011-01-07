
modISV.window.CreateUpgradeOrder = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: 'Create License Order',
        height: 150,
        width: 500,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/order/quickcreate'
        },
        fields: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'numberfield',
                fieldLabel: 'License',
                name: 'license',
                description: 'The ID of the corresponding license.',
                width: 300
            },
            {
                xtype: 'numberfield',
                fieldLabel: 'Unit Price',
                name: 'unit_price',
                description: 'The unit price of the upgrade, e.g. 99.95.',
                width: 300
            },
            {
                xtype: 'modisv-combo-edition',
                fieldLabel: 'Upgrade To',
                name: 'edition',
                hiddenName: 'edition',
                description: 'The edition to upgrade to.',
                width: 300
            },
            {
                xtype: 'hidden',
                name: '_action', // to avoid overriding MODx.Window.action
                value: 'upgrade'
            }]
        }]
    });
    modISV.window.CreateUpgradeOrder.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.CreateUpgradeOrder, MODx.Window);
Ext.reg('modisv-window-create-upgrade-order', modISV.window.CreateUpgradeOrder);