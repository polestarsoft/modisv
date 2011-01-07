
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-license'
    });
});

modISV.page.License = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-license',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.License.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.License, MODx.Component);
Ext.reg('modisv-page-license', modISV.page.License);