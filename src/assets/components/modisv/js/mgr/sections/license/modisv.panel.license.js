
modISV.panel.License = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'license',
        headerField: 'id',
        extraTabs: [{
            title: 'Hardware IDs',
            items: [{
                xtype: 'modisv-grid-hardwareids',
                preventRender: true
            }]
        }]
    });
    modISV.panel.License.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.License, modISV.UpdatePanel, {
    submitSuccess: function (o) {
        modISV.panel.License.superclass.submitSuccess.call(this, o);
        this.loadEntity();
    }
});
Ext.reg('modisv-panel-license', modISV.panel.License);
