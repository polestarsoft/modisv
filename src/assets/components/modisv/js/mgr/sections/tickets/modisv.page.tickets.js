
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-tickets'
    });
});

modISV.page.Tickets = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-tickets',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Tickets.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Tickets, MODx.Component);
Ext.reg('modisv-page-tickets', modISV.page.Tickets);