
modISV.Tabs = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        border: true,
        bodyStyle: 'padding: 10px',
        defaults: {
            border: false,
            autoHeight: true
        }
    });
    modISV.Tabs.superclass.constructor.call(this,config);
};
Ext.extend(modISV.Tabs, MODx.Tabs);
Ext.reg('modisv-tabs', modISV.Tabs);