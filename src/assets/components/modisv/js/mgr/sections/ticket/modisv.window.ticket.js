
modISV.window.Ticket = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'ticket'
    });
    modISV.window.Ticket.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.Ticket, modISV.Window);
Ext.reg('modisv-window-ticket', modISV.window.Ticket);
