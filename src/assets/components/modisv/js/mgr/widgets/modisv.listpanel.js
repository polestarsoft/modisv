
/**
 * A panel used to list all instances of an entity.
 */
modISV.ListPanel = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        baseCls: 'modx-formpanel',
        items: [{
            html: '<h2>' + config.headerText + '</h2>',
            border: false,
            cls: 'modx-page-header'
        },
        {
            xtype: 'modisv-tabs',
            items: config.tabs
        }]
    });
    
    modISV.ListPanel.superclass.constructor.call(this, config);
};
Ext.extend(modISV.ListPanel, MODx.Panel);
Ext.reg('modisv-listpanel', modISV.ListPanel);