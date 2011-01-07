
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-licenses'
    });
});

modISV.page.Licenses = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-licenses',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Licenses.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Licenses, MODx.Component);
Ext.reg('modisv-page-licenses', modISV.page.Licenses);