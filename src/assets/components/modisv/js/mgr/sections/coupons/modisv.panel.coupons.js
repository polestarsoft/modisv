
modISV.panel.Coupons = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        headerText: 'Coupons',
        tabs: [{
            title: 'Coupons',
            items: [{
                html: '<p>Here you can manage your coupons.</p><br />',
                border: false
            },
            {
                xtype: 'modisv-grid-coupons',
                preventRender: true
            }]
        }]
    });
    modISV.panel.Coupons.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Coupons, modISV.ListPanel);
Ext.reg('modisv-panel-coupons', modISV.panel.Coupons);