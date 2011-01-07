
modISV.window.HardwareID = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        entity: 'hardwareid',
        parentEntity: 'license'
    });
    modISV.window.HardwareID.superclass.constructor.call(this, config);
};
Ext.extend(modISV.window.HardwareID, modISV.CreateWindow);
Ext.reg('modisv-window-hardwareid', modISV.window.HardwareID);
