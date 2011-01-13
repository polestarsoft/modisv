
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-milestone'
    });
});

modISV.page.Milestone = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-milestone',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Milestone.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Milestone, MODx.Component);
Ext.reg('modisv-page-milestone', modISV.page.Milestone);