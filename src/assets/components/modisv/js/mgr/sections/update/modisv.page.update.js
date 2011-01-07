
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-update'
    });
});

modISV.page.Update = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-update',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Update.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Update, MODx.Component);
Ext.reg('modisv-page-update', modISV.page.Update);