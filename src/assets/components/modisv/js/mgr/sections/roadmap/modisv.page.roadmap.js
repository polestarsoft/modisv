
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-roadmap'
    });
});

modISV.page.Roadmap = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-roadmap',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Roadmap.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Roadmap, MODx.Component);
Ext.reg('modisv-page-roadmap', modISV.page.Roadmap);