
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-client'
    });
});

modISV.page.Client = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-client',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Client.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Client, MODx.Component);
Ext.reg('modisv-page-client', modISV.page.Client);