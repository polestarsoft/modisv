
modISV.panel.Licenses = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        headerText: 'Licenses',
        tabs: [{
            title: 'Licenses',
            items: [{
                html: '<p>Here you can manage your licenses.</p><br />',
                border: false
            },
            {
                xtype: 'modisv-grid-licenses',
                preventRender: true
            }]
        }]
    });
    modISV.panel.Licenses.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Licenses, modISV.ListPanel);
Ext.reg('modisv-panel-licenses', modISV.panel.Licenses);