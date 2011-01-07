
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-release'
    });
});

modISV.page.Release = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-release',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Release.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Release, MODx.Component);
Ext.reg('modisv-page-release', modISV.page.Release);