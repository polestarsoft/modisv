
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-hardwareid'
    });
});

modISV.page.Edition = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-hardwareid',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Edition.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Edition, MODx.Component);
Ext.reg('modisv-page-hardwareid', modISV.page.Edition);