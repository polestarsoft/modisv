
modISV.panel.Edition = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'hardwareid',
        headerText: 'Hardware ID'
    });
    modISV.panel.Edition.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Edition, modISV.UpdatePanel);
Ext.reg('modisv-panel-hardwareid', modISV.panel.Edition);