
modISV.panel.Roadmap = function (config) {
    config = config || {};
    Ext.apply(config, {
        border: false,
        headerText: 'Roadmap',
        tabs: [{
            title: 'Milestones',
            items: [{
                html: '<p>Here you can manage your milestones.</p><br />',
                border: false
            },
            {
                xtype: 'modisv-grid-milestones',
                preventRender: true
            }]
        }]
    });
    modISV.panel.Roadmap.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Roadmap, modISV.ListPanel);
Ext.reg('modisv-panel-roadmap', modISV.panel.Roadmap);