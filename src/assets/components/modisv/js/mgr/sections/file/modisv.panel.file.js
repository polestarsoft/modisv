
modISV.panel.File = function (config) {
    config = config || {};
    Ext.apply(config, {
        entity: 'file'
    });
    modISV.panel.File.superclass.constructor.call(this, config);
};
Ext.extend(modISV.panel.File, modISV.UpdatePanel);
Ext.reg('modisv-panel-file', modISV.panel.File);
