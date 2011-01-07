
modISV.panel.Release = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'release',
        extraTabs: [{
            title: 'Updates',
            items: [{
                xtype: 'modisv-grid-updates',
                preventRender: true
            }]
        },
        {
            title: 'Editions',
            items: [{
                xtype: 'modisv-grid-editions',
                preventRender: true
            }]
        },
        {
            title: 'Suscriptions',
            items: [{
                xtype: 'modisv-grid-subscriptions',
                preventRender: true
            }]
        },
        {
            title: 'Files',
            items: [{
                xtype: 'modisv-grid-files',
                preventRender: true
            }]
        }]
    });
    modISV.panel.Release.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Release, modISV.UpdatePanel);
Ext.reg('modisv-panel-release', modISV.panel.Release);