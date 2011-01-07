
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-file'
    });
});

modISV.page.File = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-file',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.File.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.File, MODx.Component);
Ext.reg('modisv-page-file', modISV.page.File);