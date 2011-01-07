
modISV.panel.Edition = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'edition'
    });
    modISV.panel.Edition.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.Edition, modISV.UpdatePanel);
Ext.reg('modisv-panel-edition', modISV.panel.Edition);