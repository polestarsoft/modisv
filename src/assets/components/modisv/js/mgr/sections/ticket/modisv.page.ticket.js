
Ext.onReady(function() {
    MODx.load({
        xtype: 'modisv-page-ticket'
    });
});

modISV.page.Ticket = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'modisv-panel-ticket',
            renderTo: 'modisv-panel-root-div'
        }]
    });
    modISV.page.Ticket.superclass.constructor.call(this, config);
};
Ext.extend(modISV.page.Ticket, MODx.Component);
Ext.reg('modisv-page-ticket', modISV.page.Ticket);